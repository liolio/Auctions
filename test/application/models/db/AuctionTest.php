<?php

/**
 * @class AuctionTest
 */
class AuctionTest extends TestCase_Database
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
    
}
