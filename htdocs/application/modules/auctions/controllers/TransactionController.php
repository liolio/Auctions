<?php
/**
 * @class Auctions_TransactionController
 */
class Auctions_TransactionController extends Controller_Abstract
{
    
    public function bidAction()
    {
        if (!Zend_Auth::getInstance()->hasIdentity())
            $this->_helper->redirector('index', 'login');
        
        $this->view->auction = AuctionTable::getInstance()->find($this->getRequest()->getParam(FieldIdEnum::AUCTION_ID));;
        $this->view->categoriesCollection = $this->view->auction->Category->getCategoryWithParentsForCategory();
        $this->view->numberOfItemsLeft = TransactionTable::getInstance()->getNumberOfItemsLeftForAuctionAndTransactionTypeName($this->view->auction);
        
        $auctionTransactionType = AuctionTransactionTypeTable::getInstance()->getAuctionTransactionType(
                $this->view->auction, Enum_Db_TransactionType_Type::BIDDING);
        
        $this->view->form = new Auctions_Form_Transaction_Add();
        $this->view->form->getElement(FieldIdEnum::AUCTION_ID)->setValue($this->view->auction->id);
        $this->view->form->getElement(FieldIdEnum::TRANSACTION_TYPE_NAME)->setValue(Enum_Db_TransactionType_Type::BIDDING);
        $this->view->form->getElement(FieldIdEnum::TRANSACTION_PRICE)->setValue($auctionTransactionType->countPrice());
    }
    
    public function buyOutAction()
    {
        if (!Zend_Auth::getInstance()->hasIdentity())
            $this->_helper->redirector('index', 'login');
        
        $this->view->auction = AuctionTable::getInstance()->find($this->getRequest()->getParam(FieldIdEnum::AUCTION_ID));;
        $this->view->categoriesCollection = $this->view->auction->Category->getCategoryWithParentsForCategory();
        $this->view->numberOfItemsLeft = TransactionTable::getInstance()->getNumberOfItemsLeftForAuctionAndTransactionTypeName($this->view->auction);
        
        $auctionTransactionType = AuctionTransactionTypeTable::getInstance()->getAuctionTransactionType(
                $this->view->auction, Enum_Db_TransactionType_Type::BUY_OUT);
        
        $this->view->form = new Auctions_Form_Transaction_Add();
        $this->view->form->getElement(FieldIdEnum::AUCTION_ID)->setValue($this->view->auction->id);
        $this->view->form->getElement(FieldIdEnum::TRANSACTION_TYPE_NAME)->setValue(Enum_Db_TransactionType_Type::BUY_OUT);
        $this->view->form->getElement(FieldIdEnum::TRANSACTION_PRICE)
                ->setAttrib('readonly', 'true')
                ->setAttrib('class', 'formTextReadOnly')
                ->setValue($auctionTransactionType->countPrice());
    }
    
    public function processTransactionFormAction()
    {
        $request = $this->getRequest();
        $isBuyOut = $request->getParam(FieldIdEnum::TRANSACTION_TYPE_NAME) === Enum_Db_TransactionType_Type::BUY_OUT;
        
        if (!$request->isPost())
            return $this->_helper->redirector('index', 'index');
        
        $form = new Auctions_Form_Transaction_Add();
        if (!$form->isValid($request->getPost()))
        {
            if ($isBuyOut)
                $this->buyOutAction();
            else
                $this->bidAction();
            
            $this->view->form->isValid($form->getValues());
            
            return $this->render('transaction');
        }
        
        $auctionTransactionType = AuctionTransactionTypeTable::getInstance()->getAuctionTransactionType(
            AuctionTable::getInstance()->find($form->getElement(FieldIdEnum::AUCTION_ID)->getValue()),
            $form->getElement(FieldIdEnum::TRANSACTION_TYPE_NAME)->getValue()
        );
        
        if ($auctionTransactionType->Auction->stage === Enum_Db_Auction_Stage::FINISHED)
            return $this->_helper->redirector($form->getElement(FieldIdEnum::AUCTION_ID)->getValue(), 'show', 'auction');
        
        try {
            Doctrine_Manager::connection()->beginTransaction();
            
            $biddingTransactionssBeforeTransaction = $this->_getBiddingsBeforeTransaction($auctionTransactionType->Auction);
            
            $transaction = Transaction_Factory::create(
                Auth_User::getInstance()->getUser(), 
                AuctionTransactionTypeTable::getInstance()->getAuctionTransactionType(
                    AuctionTable::getInstance()->find($form->getElement(FieldIdEnum::AUCTION_ID)->getValue()),
                    $form->getElement(FieldIdEnum::TRANSACTION_TYPE_NAME)->getValue()
                ),
                array(
                    FieldIdEnum::TRANSACTION_PRICE              =>  $form->getValue(FieldIdEnum::TRANSACTION_PRICE),
                    FieldIdEnum::TRANSACTION_NUMBER_OF_ITEMS    =>  $form->getValue(FieldIdEnum::TRANSACTION_NUMBER_OF_ITEMS)
                )
            );
            $transaction->save();
            
            if ($isBuyOut)
                DeliveryForm_Factory::create($transaction)->save();
            
            $this->_sendNotifications($biddingTransactionssBeforeTransaction, $auctionTransactionType->Auction, $form, $transaction);
            
            Doctrine_Manager::connection()->commit();
        }
        catch (Exception $ex)
        {
            Doctrine_Manager::connection()->rollback();
            Log_Factory::create($ex, Zend_Log::CRIT);
            $form->setDescription('Failure!');
            
            if ($form->getElement(FieldIdEnum::TRANSACTION_TYPE_NAME)->getValue() === Enum_Db_TransactionType_Type::BUY_OUT)
                $this->buyOutAction();
            else
                $this->bidAction();
            
            $this->view->form->isValid($form->getValues());
            
            return $this->render('transaction');
        }
        
        Session_DialogWindow::save($isBuyOut ?
            ParamIdEnum::WINDOW_BUY_OUT :
            ParamIdEnum::WINDOW_BID
        );
        
        $this->_helper->redirector($form->getElement(FieldIdEnum::AUCTION_ID)->getValue(), 'show', 'auction');
    }
    
    private function _getBiddingsBeforeTransaction(Auction $auction)
    {
        $biddingAuctionTransactionType = AuctionTransactionTypeTable::getInstance()->getAuctionTransactionType($auction, Enum_Db_TransactionType_Type::BIDDING);
        if ($biddingAuctionTransactionType === false)
            return array();
        
        $transactions = $biddingAuctionTransactionType->getItemsToShow();
        $validTransactions = array();

        foreach($transactions[ParamIdEnum::TRANSACTION_VALID] as $transaction)
            $validTransactions[$transaction->id] = $transaction;
        
        return $validTransactions;
    }
    
    private function _sendNotifications(array $biddingTransactionssBeforeTransaction, Auction $auction, Auctions_Form_Transaction_Add $form, 
            Transaction $transaction)
    {
        $notificationSender = new Notification_Sender();

        if ($form->getElement(FieldIdEnum::TRANSACTION_TYPE_NAME)->getValue() === Enum_Db_TransactionType_Type::BIDDING)
        {
            $notificationSender->send($transaction, Enum_Db_Notification_Type::AUCTION_BID_BIDDER);
            $notificationSender->send($transaction, Enum_Db_Notification_Type::AUCTION_BID_AUCTION_OWNER);
        }
        else 
        {
            $notificationSender->send($transaction, Enum_Db_Notification_Type::AUCTION_BUY_OUT_CUSTOMER);
            $notificationSender->send($transaction, Enum_Db_Notification_Type::AUCTION_BUY_OUT_AUCTION_OWNER);
        }
        
        $this->_notifyOutbiddedUsers($biddingTransactionssBeforeTransaction, $notificationSender, $auction);
    }
    
    private function _notifyOutbiddedUsers(array $biddingTransactionssBeforeTransaction, Notification_Sender $notificationSender, Auction $auction)
    {
        $biddingAuctionTransactionType = AuctionTransactionTypeTable::getInstance()->getAuctionTransactionType($auction, Enum_Db_TransactionType_Type::BIDDING);
        
        if ($biddingAuctionTransactionType !== false)
        {
            $transactions = $biddingAuctionTransactionType->getItemsToShow();
            foreach ($transactions[ParamIdEnum::TRANSACTION_VALID] as $transaction)
                unset($biddingTransactionssBeforeTransaction[$transaction->id]);

            foreach ($biddingTransactionssBeforeTransaction as $outbiddedTransaction)
                $notificationSender->send($outbiddedTransaction, Enum_Db_Notification_Type::AUCTION_BID_OUTBIDDED);
        }
    }
    
}
