<?php
/**
 * @class Auctions_TranasctionController_ProcessTransactionFormActionTest
 */
class Auctions_TranasctionController_ProcessTransactionFormActionTest extends TestCase_Mail
{
    
    /**
     * @test
     */
    public function proccessBiddingWithValidData()
    {
        $this->_loadFixtures(array(
            'Category/1',
            'Currency/1',
            'Auction/5_category_1_start_2012-05-02',
            'AuctionTransactionType/4_auction_5_tt_1',
            'AuctionTransactionType/5_auction_5_tt_2',
            'User/2',
            'User/3_inactive',
            "Transaction/3_att_4_u_1", 
            "Transaction/4_att_4_u_2", 
            "Transaction/7_att_4_u_3"
        ));
        
        $request = array(
            FieldIdEnum::AUCTION_ID                     =>  '5',
            FieldIdEnum::TRANSACTION_TYPE_NAME          =>  Enum_Db_TransactionType_Type::BIDDING,
            FieldIdEnum::TRANSACTION_PRICE              =>  '10000',
            FieldIdEnum::TRANSACTION_NUMBER_OF_ITEMS    =>  '5',
        );
        
        $this->_setRequest($request);
        
        $this->dispatch("transaction/process-transaction-form");
        $this->_assertDispatch('transaction', 'process-transaction-form');
        $this->_assertRedirection('auction/show/5');
        
        $transactions = TransactionTable::getInstance()->findAll();
        $this->assertEquals(4, count($transactions));
        
        $transaction = $transactions->get(3);
        $transaction->refresh(true);
        $this->assertEquals(1, $transaction->User->id);
        $this->assertEquals($request[FieldIdEnum::AUCTION_ID], $transaction->AuctionTransactionType->Auction->id);
        $this->assertEquals($request[FieldIdEnum::TRANSACTION_TYPE_NAME], $transaction->AuctionTransactionType->TransactionType->name);
        $this->assertEquals($request[FieldIdEnum::TRANSACTION_PRICE], $transaction->price);
        $this->assertEquals($request[FieldIdEnum::TRANSACTION_NUMBER_OF_ITEMS], $transaction->number_of_items);
        
        $notifications = NotificationTable::getInstance()->findAll();
        $this->assertEquals(4, count($notifications));
        
        $notification1 = $notifications->get(0);
        $this->assertEquals(8, $notification1->related_object_id);
        $this->assertEquals(Enum_Db_Notification_Type::AUCTION_BID_BIDDER, $notification1->type);
        
        $notification2 = $notifications->get(1);
        $this->assertEquals(8, $notification2->related_object_id);
        $this->assertEquals(Enum_Db_Notification_Type::AUCTION_BID_AUCTION_OWNER, $notification2->type);
        
        $notification3 = $notifications->get(2);
        $this->assertEquals(7, $notification3->related_object_id);
        $this->assertEquals(Enum_Db_Notification_Type::AUCTION_BID_OUTBIDDED, $notification3->type);
        
        $notification4 = $notifications->get(3);
        $this->assertEquals(4, $notification4->related_object_id);
        $this->assertEquals(Enum_Db_Notification_Type::AUCTION_BID_OUTBIDDED, $notification4->type);
    }
    
    /**
     * @test
     */
    public function proccessBiddingWithInvalidData()
    {
        $this->_loadFixtures(array(
            'Category/1',
            'Currency/1',
            'Auction/5_category_1_start_2012-05-02',
            'AuctionTransactionType/4_auction_5_tt_1',
            'AuctionTransactionType/5_auction_5_tt_2'
        ));
        
        $request = array(
            FieldIdEnum::AUCTION_ID                     =>  '5',
            FieldIdEnum::TRANSACTION_TYPE_NAME          =>  Enum_Db_TransactionType_Type::BIDDING,
            FieldIdEnum::TRANSACTION_PRICE              =>  '1',
            FieldIdEnum::TRANSACTION_NUMBER_OF_ITEMS    =>  '15',
        );
        
        $this->_setRequest($request);
        $this->dispatch("transaction/process-transaction-form");
        $this->_assertDispatch('transaction', 'process-transaction-form');
        
        $body = $this->getResponse()->getBody();
        
        $this->assertContains($this->_getTranslator()->translate("validation_message-transaction_price_lower_than_minimum_price"), $body);
        $this->assertContains($this->_getTranslator()->translate("validation_message-transaction_number_of_items_greater_than_items_left"), $body);
    }
    
    /**
     * @test
     */
    public function proccessBuyOutWithValidData()
    {
        $this->_loadFixtures(array(
            'Category/1',
            'Currency/1',
            'Auction/5_category_1_start_2012-05-02',
            'AuctionTransactionType/4_auction_5_tt_1',
            'AuctionTransactionType/5_auction_5_tt_2',
            'User/2',
            'User/3_inactive',
            "Transaction/3_att_4_u_1", 
            "Transaction/4_att_4_u_2", 
            "Transaction/7_att_4_u_3"
        ));
        
        $request = array(
            FieldIdEnum::AUCTION_ID                     =>  '5',
            FieldIdEnum::TRANSACTION_TYPE_NAME          =>  Enum_Db_TransactionType_Type::BUY_OUT,
            FieldIdEnum::TRANSACTION_PRICE              =>  '3210.12',
            FieldIdEnum::TRANSACTION_NUMBER_OF_ITEMS    =>  '5',
        );
        
        $this->_setRequest($request);
        
        $this->dispatch("transaction/process-transaction-form");
        $this->_assertDispatch('transaction', 'process-transaction-form');
        $this->_assertRedirection('auction/show/5');
        
        $transactions = TransactionTable::getInstance()->findAll();
        $this->assertEquals(4, count($transactions));
        
        $transaction = $transactions->get(3);
        $transaction->refresh(true);
        $this->assertEquals(1, $transaction->User->id);
        $this->assertEquals($request[FieldIdEnum::AUCTION_ID], $transaction->AuctionTransactionType->Auction->id);
        $this->assertEquals($request[FieldIdEnum::TRANSACTION_TYPE_NAME], $transaction->AuctionTransactionType->TransactionType->name);
        $this->assertEquals($request[FieldIdEnum::TRANSACTION_PRICE], $transaction->price);
        $this->assertEquals($request[FieldIdEnum::TRANSACTION_NUMBER_OF_ITEMS], $transaction->number_of_items);
        
        $notifications = NotificationTable::getInstance()->findAll();
        $this->assertEquals(4, count($notifications));
        
        $notification1 = $notifications->get(0);
        $this->assertEquals(8, $notification1->related_object_id);
        $this->assertEquals(Enum_Db_Notification_Type::AUCTION_BUY_OUT_CUSTOMER, $notification1->type);
        
        $notification2 = $notifications->get(1);
        $this->assertEquals(8, $notification2->related_object_id);
        $this->assertEquals(Enum_Db_Notification_Type::AUCTION_BUY_OUT_AUCTION_OWNER, $notification2->type);
        
        $notification3 = $notifications->get(2);
        $this->assertEquals(7, $notification3->related_object_id);
        $this->assertEquals(Enum_Db_Notification_Type::AUCTION_BID_OUTBIDDED, $notification3->type);
        
        $notification4 = $notifications->get(3);
        $this->assertEquals(4, $notification4->related_object_id);
        $this->assertEquals(Enum_Db_Notification_Type::AUCTION_BID_OUTBIDDED, $notification4->type);
    }
    
    /**
     * @test
     */
    public function proccessBuyOutWithInvalidData()
    {
        $this->_loadFixtures(array(
            'Category/1',
            'Currency/1',
            'Auction/5_category_1_start_2012-05-02',
            'AuctionTransactionType/4_auction_5_tt_1',
            'AuctionTransactionType/5_auction_5_tt_2'
        ));
        
        $request = array(
            FieldIdEnum::AUCTION_ID                     =>  '5',
            FieldIdEnum::TRANSACTION_TYPE_NAME          =>  Enum_Db_TransactionType_Type::BUY_OUT,
            FieldIdEnum::TRANSACTION_PRICE              =>  '1',
            FieldIdEnum::TRANSACTION_NUMBER_OF_ITEMS    =>  '15',
        );
        
        $this->_setRequest($request);
        $this->dispatch("transaction/process-transaction-form");
        $this->_assertDispatch('transaction', 'process-transaction-form');
        
        $body = $this->getResponse()->getBody();
        
        $this->assertContains($this->_getTranslator()->translate("validation_message-transaction_price_lower_than_minimum_price"), $body);
        $this->assertContains($this->_getTranslator()->translate("validation_message-transaction_number_of_items_greater_than_items_left"), $body);
    }
}
