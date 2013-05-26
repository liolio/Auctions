<?php

/**
 * @class AuctionTest
 */
class AuctionTest extends TestCase_Controller
{
 
    /**
     * @test
     * @dataProvider isStartedAndNotFinishedDataProvider
     */
    public function isStartedAndNotFinished($daysDiffFromNow, $expectedResult)
    {
        $auction = new Auction();
        $auction->start_time = Zend_Date::now()->addDay($daysDiffFromNow)->toString(Time_Format::getFullDateTimeFormat());
        $auction->duration = "7";
        
        $this->assertEquals($expectedResult, $auction->isStartedAndNotFinished());
    }

    public function isStartedAndNotFinishedDataProvider()
    {
        return array(
            array(-1, true),
            array(-10, false),
            array(10, false)
        );
    }
    
    /**
     * @test
     */
    public function getEndTime()
    {
        $this->_loadFixtures(array(
            "Category/1",
            "Currency/1",
            "Auction/1_category_1_start_2012-05-02"
        ));
        
        $this->assertEquals(
            "2012-05-09 22:22:22",
            AuctionTable::getInstance()->find(1)->getEndTime()
        );
    }
    
    /**
     * @test
     */
    public function getOrdereAuctionTransactionTypes()
    {
        $this->_loadFixtures(array(
            "Category/1",
            "Currency/1",
            "Auction/1_category_1_start_2012-05-02",
            "AuctionTransactionType/1_auction_1_tt_2",
            "AuctionTransactionType/2_auction_1_tt_1",
        ));
        
        $auctionTransactionTypes = AuctionTable::getInstance()->find(1)->getOrdereAuctionTransactionTypes();
        $this->assertEquals(2, $auctionTransactionTypes->count());
        
        $bidding = $auctionTransactionTypes->get(0);
        $this->assertEquals(Enum_Db_TransactionType_Type::BIDDING, $bidding->TransactionType->name);
        
        $buyOut = $auctionTransactionTypes->get(1);
        $this->assertEquals(Enum_Db_TransactionType_Type::BUY_OUT, $buyOut->TransactionType->name);
    }
    
    /**
     * @test
     * @dataProvider getNotificationDataDataProvider
     */
    public function getNotificationData($notificationType, array $expectedData)
    {
        $this->_loadFixtures(array(
            "Category/1",
            "Currency/1",
            "Auction/1_category_1_start_2012-05-02",
        ));
        
        $this->assertEquals($expectedData,AuctionTable::getInstance()->find(1)->getNotificationData($notificationType));
    }
    
    public function getNotificationDataDataProvider()
    {
        return array(
            array(
                Enum_Db_Notification_Type::AUCTION_FINISHED_OWNER,
                array(
                    FieldIdEnum::AUCTION_TITLE                  =>  'Auction 1',
                    ParamIdEnum::USER_FULLNAME                  =>  'Admin Adminowy',
                    ParamIdEnum::LINK                           =>  '/auction/show/1'
                )
            ),
        );
    }
    
    /**
     * @test
     */
    public function getRecipients()
    {
        $this->_loadFixtures(array(
            "Category/1",
            "Currency/1",
            "Auction/1_category_1_start_2012-05-02",
        ));
        
        $this->assertEquals(array('lio_lio@wp.pl'), AuctionTable::getInstance()->find(1)->getRecipients('not_important'));
    }
    
    /**
     * @test
     */
    public function getRelatedObjectId()
    {
        $this->_loadFixtures(array(
            "Category/1",
            "Currency/1",
            "Auction/1_category_1_start_2012-05-02",
        ));
        
        $this->assertEquals(1, AuctionTable::getInstance()->find(1)->getRelatedObjectId());
    }
    
}
