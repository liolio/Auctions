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
    
    /**
     * @test
     */
    public function getDeliveryOptionsCashOnDelivery()
    {
        $this->_loadFixtures(array(
            "Category/1",
            "Currency/1",
            "Auction/1_category_1_start_2012-05-02",
            "DeliveryType/1",
            "DeliveryType/2",
            "DeliveryType/3",
            "DeliveryType/4",
            "Delivery/1_delivery_type_1_auction_1",
            "Delivery/2_delivery_type_2_auction_1",
            "Delivery/3_delivery_type_3_auction_1",
            "Delivery/4_delivery_type_4_auction_1"
        ));
        
        $deliveries = AuctionTable::getInstance()->find(1)->getDeliveryOptions(true);
        $this->assertEquals(2, count($deliveries));
        
        $delivery1 = $deliveries->get(0);
        $this->assertEquals('Poczta polska', $delivery1->DeliveryType->name);
        $this->assertEquals('0.10', $delivery1->price);
        
        $delivery2 = $deliveries->get(1);
        $this->assertEquals('Kurier', $delivery2->DeliveryType->name);
        $this->assertEquals('1.22', $delivery2->price);
    }
    
    /**
     * @test
     */
    public function getDeliveryOptionsCashOnTransaction()
    {
        $this->_loadFixtures(array(
            "Category/1",
            "Currency/1",
            "Auction/1_category_1_start_2012-05-02",
            "DeliveryType/1",
            "DeliveryType/2",
            "DeliveryType/3",
            "DeliveryType/4",
            "Delivery/1_delivery_type_1_auction_1",
            "Delivery/2_delivery_type_2_auction_1",
            "Delivery/3_delivery_type_3_auction_1",
            "Delivery/4_delivery_type_4_auction_1"
        ));
        
        $deliveries = AuctionTable::getInstance()->find(1)->getDeliveryOptions(false);
        $this->assertEquals(2, count($deliveries));
        
        $delivery1 = $deliveries->get(0);
        $this->assertEquals('Kurier', $delivery1->DeliveryType->name);
        $this->assertEquals('0.11', $delivery1->price);
        
        $delivery2 = $deliveries->get(1);
        $this->assertEquals('Poczta polska', $delivery2->DeliveryType->name);
        $this->assertEquals('2.22', $delivery2->price);
    }
}
