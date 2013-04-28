<?php
/**
 * @class Auctions_AuctionController
 */
class Auctions_AuctionController extends Controller_Abstract
{

    public function init()
    {
        Zend_Layout::startMvc();
    }
    
    public function addAction()
    {
        $this->view->addForm = new Auctions_Form_Auction_Add();
    }
    
    public function processAddFormAction()
    {
        $request = $this->getRequest();

        if (!$request->isPost())
            return $this->_helper->redirector('add');
        
        $form = new Auctions_Form_Auction_Add();
        
        
        if (! $this->_validateProcessAddFormAction($request, $form))
            return $this->render('add');

        try {
            Doctrine_Manager::connection()->beginTransaction();
            
            $auctionFileId = $form->getValue(FieldIdEnum::AUCTION_FILE_ID);
            $thumbnail = null;
            
            $files = array();
            for ($i = 1; $i < 6; $i++)
            {
                $file = $this->_saveFile($form, ParamIdEnum::FILE . '_' . $i);
                
                if (!is_null($file))
                {
                    if ($auctionFileId == $i)
                        $thumbnail = $file;
                
                    $files[] = $file;
                }
            }
            
            $auction = Auction_Factory::create(
                array(
                    FieldIdEnum::AUCTION_TITLE => $form->getValue(FieldIdEnum::AUCTION_TITLE),
                    FieldIdEnum::AUCTION_DESCRIPTION => $form->getValue(ParamIdEnum::CKEDITOR),
                    FieldIdEnum::AUCTION_DURATION => $form->getValue(FieldIdEnum::AUCTION_DURATION),
                    FieldIdEnum::AUCTION_START_TIME => $form->getValue(FieldIdEnum::AUCTION_START_TIME),
                    FieldIdEnum::AUCTION_NUMBER_OF_ITEMS => $form->getValue(FieldIdEnum::AUCTION_NUMBER_OF_ITEMS),
                ), 
                CategoryTable::getInstance()->find($form->getValue(FieldIdEnum::CATEGORY_ID)),
                CurrencyTable::getInstance()->find($form->getValue(FieldIdEnum::CURRENCY_ID)),
                Auth_User::getInstance()->getUser(),
                $thumbnail
            );
            $auction->save();
            
            foreach ($files as $file)
                Attachment_Factory::create($auction, $file)->save();
            
            $this->_saveAuctionTransactionTypes($form, $auction);
            
            $this->_saveDeliveries($form, $auction);
            
            Doctrine_Manager::connection()->commit();
        }
        catch (Exception $ex)
        {
            Doctrine_Manager::connection()->rollback();
            Log_Factory::create($ex, Zend_Log::CRIT);
            $this->view->addForm = $form;
            $this->view->message = 'Failure!';
            return $this->render('add');
        }
        
        $this->_helper->redirector($auction->id, 'show', 'auction');
    }
    
    public function showAction()
    {
        $auction = AuctionTable::getInstance()->find($this->getRequest()->getParam(FieldIdEnum::AUCTION_ID));
        
        $this->view->auction = $auction;
        $this->view->categoriesCollection = $auction->Category->getCategoryWithParentsForCategory();
    }

    public function showListForCategoryAction()
    {
        $categoryId = $this->getRequest()->getParam(FieldIdEnum::CATEGORY_ID);
        $category = CategoryTable::getInstance()->find($categoryId);
        
        $this->_setCategoriesList($category);
        $this->view->auctionsArray = AuctionTable::getInstance()->getAuctionsAllChildrenAuctions($category, Zend_Date::now());
    }
    
    private function _setCategoriesList(Category $category)
    {
        $activeCategories = $category->getCategoryAllParentIds();
        $activeCategories[] = $category->id;
        $this->view->activeCategoriesIds = $activeCategories;
        
        $this->view->categoriesIdsToShow = CategoryTable::getInstance()->getCategoriesToExpand($category);
        
        $this->view->categories = CategoryTable::getInstance()->getCategoriesList();
    }
    
    private function _validateProcessAddFormAction(Zend_Controller_Request_Abstract $request, Zend_Form $form)
    {
        $formValidatorsContainer = new Validate_Form_Container(Validate_Form_Container::MODE_AND);
        $formValidatorsContainer->addValidator(new Validate_Form_AuctionTransactionType_AtLeastOneChosen());
        $formValidatorsContainer->addValidator(new Validate_Form_Delivery_AtLeastOneChosen());
        
        if (!$form->isValid($request->getPost()) || !$formValidatorsContainer->isValid($form))
        {
            $this->view->message = $formValidatorsContainer->getMessage();
            $this->view->addForm = $form;
            
            return false;
        }
        
        return true;
    }
    
    private function _saveAuctionTransactionTypes(Zend_Form $form, Auction $auction)
    {
        if ($form->getValue(ParamIdEnum::AUCTION_TRANSACTION_TYPE_BIDDING) != 0)
            {
                AuctionTransactionType_Factory::create(
                    array(
                        FieldIdEnum::AUCTION_TRANSACTION_TYPE_PRICE =>  $form->getValue(ParamIdEnum::AUCTION_TRANSACTION_TYPE_BIDDING_PRICE),
                        FieldIdEnum::TRANSACTION_TYPE_NAME          =>  Enum_Db_TransactionType_Type::BIDDING
                    ), 
                    $auction
                )->save();
            }
            
            if ($form->getValue(ParamIdEnum::AUCTION_TRANSACTION_TYPE_BUY_OUT) != 0)
            {
                AuctionTransactionType_Factory::create(
                    array(
                        FieldIdEnum::AUCTION_TRANSACTION_TYPE_PRICE =>  $form->getValue(ParamIdEnum::AUCTION_TRANSACTION_TYPE_BUY_OUT_PRICE),
                        FieldIdEnum::TRANSACTION_TYPE_NAME          =>  Enum_Db_TransactionType_Type::BUY_OUT
                    ), 
                    $auction
                )->save();
            }
    }
    
    private function _saveDeliveries(Zend_Form $form, Auction $auction)
    {
        foreach (DeliveryTypeTable::getInstance()->getIds() as $id)
        {
            if ($form->getValue(FieldIdEnum::DELIVERY_TYPE_ID . "_" . $id) != 0)
            {
                Delivery_Factory::create(
                    array(FieldIdEnum::DELIVERY_PRICE => $form->getValue(FieldIdEnum::DELIVERY_PRICE . "_" . $id)),
                    $auction,
                    DeliveryTypeTable::getInstance()->find($id)
                )->save();
            }
        }
    }
    
    private function _saveFile(Zend_Form $form, $fieldId)
    {
        $file = null;
        $fileElement = $form->getElement($fieldId);

        if (!is_null($fileElement))
        {
            $fileName = $fileElement->getFileName();
            if (!empty($fileName))
            {
                $originalFilename = pathinfo($fileElement->getFileName());
                $fileInfo = $fileElement->getFileInfo();
                $newFilename = 'file-' . uniqid() . '.' . $originalFilename['extension'];

                $fileElement->addFilter('Rename', $newFilename);
                $fileElement->receive();

                $file = File_Factory::create(array(
                    FieldIdEnum::FILE_FILENAME          =>  $newFilename,
                    FieldIdEnum::FILE_ORIGINAL_FILENAME =>  $originalFilename['basename'],
                    FieldIdEnum::FILE_MIME_TYPE         =>  $fileElement->getMimeType(),
                    FieldIdEnum::FILE_SIZE              =>  $fileInfo[$fieldId]['size'],
                ), Auth_User::getInstance()->getUser());

                $file->save();
            }
        }
        
        return $file;
    }
}