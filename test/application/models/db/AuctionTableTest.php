<?php
/**
 * @class AuctionTableTest
 */
class AuctionTableTest extends TestCase_Database
{
    
    /**
     * @test
     * @dataProvider getAuctionsAllChildrenAuctionsProvider
     */
    public function getAuctionsAllChildrenAuctions($now, $categoryId, array $expectedResult)
    {
        $this->_loadFixtures(array(
            'Category/1',
            'Category/3_parent_1',
            'Currency/1',
            
            'Auction/1_category_1_start_2012-05-02',
            'AuctionTransactionType/1_auction_1_tt_2',
            'AuctionTransactionType/2_auction_1_tt_1',
            
            'Auction/2_category_3_start_2012-05-05',
            'AuctionTransactionType/3_auction_2_tt_2',
        ));
     
        $this->assertEquals(
            $expectedResult, 
            AuctionTable::getInstance()->getAuctionsAllChildrenAuctions(CategoryTable::getInstance()->find($categoryId), new Zend_Date($now))
        );
    }
    
    public function getAuctionsAllChildrenAuctionsProvider()
    {
        $auction1 = array(
            FieldIdEnum::AUCTION_TITLE      =>  'Auction 1',
            ParamIdEnum::AUCTION_END_TIME   =>  '2012-05-09 22:22:22',
            FieldIdEnum::CURRENCY_NAME      =>  'PLN',
            FieldIdEnum::FILE_FILENAME      =>  '',
            ParamIdEnum::AUCTION_PRICES     =>  array(
                array(
                    FieldIdEnum::TRANSACTION_TYPE_NAME          =>  Enum_Db_TransactionType_Type::BIDDING,
                    FieldIdEnum::AUCTION_TRANSACTION_TYPE_PRICE =>  "122.12"
                ),
                array(
                    FieldIdEnum::TRANSACTION_TYPE_NAME          =>  Enum_Db_TransactionType_Type::BUY_OUT,
                    FieldIdEnum::AUCTION_TRANSACTION_TYPE_PRICE =>  "22.12"
                ),
            )
        );
        
        $auction2 = array(
            FieldIdEnum::AUCTION_TITLE      =>  'Auction 2',
            ParamIdEnum::AUCTION_END_TIME   =>  '2012-05-12 22:22:22',
            FieldIdEnum::CURRENCY_NAME      =>  'PLN',
            FieldIdEnum::FILE_FILENAME      =>  '',
            ParamIdEnum::AUCTION_PRICES     =>  array(
                array(
                    FieldIdEnum::TRANSACTION_TYPE_NAME          =>  Enum_Db_TransactionType_Type::BIDDING,
                    FieldIdEnum::AUCTION_TRANSACTION_TYPE_PRICE =>  "222.32"
                ),
            )
        );
        
        return array(
            array(
                "2012-05-07", 1,
                array(
                    1   =>  $auction1,
                    2   =>  $auction2,
                )
            ),
            // before beggining of auction 2
            array(
                "2012-05-04", 1,
                array(
                    1   =>  $auction1,
                )
            ),
            // category id = 3
            array(
                "2012-05-07", 3,
                array(
                    2   =>  $auction2,
                )
            ),
            // after end of auction 1
            array(
                "2012-05-10", 1,
                array(
                    2   =>  $auction2,
                )
            ),
        );
    }
    
    /**
     * @test
     */
    public function getAuctionsToFinish()
    {
        $this->_loadFixtures(array(
            'Category/1',
            'Category/3_parent_1',
            'Currency/1',
            
            'Auction/1_category_1_start_2012-05-02',
            'Auction/2_category_3_start_2012-05-05',
            'Auction/4_category_1_start_now-1', //not finished yet
            'Auction/5_category_1_start_2012-05-02_finished', //already finished
        ));
        
        $auctions = AuctionTable::getInstance()->getAuctionsToFinish(new Zend_Date("2013-05-02 22:22:22"));
        $this->assertEquals(2, count($auctions));
        $this->assertEquals(1, $auctions->get(0)->id);
        $this->assertEquals(2, $auctions->get(1)->id);
    }
    
    /**
     * @test
     */
    public function getAuctionsForUser()
    {
        $this->_loadFixtures(array(
            'Category/1',
            'Category/3_parent_1',
            'Currency/1',
            
            'Auction/1_category_1_start_2012-05-02',
            'Auction/2_category_3_start_2012-05-05',
            'Auction/4_category_1_start_now-1', //not finished yet
            'Auction/5_category_1_start_2012-05-02_finished', //already finished
        ));
        
        $auctions = AuctionTable::getInstance()->getAuctionsForUser(UserTable::getInstance()->find(1), 3);
        $this->assertEquals(3, count($auctions));
        $this->assertEquals(1, $auctions->get(0)->id);
        $this->assertEquals(2, $auctions->get(1)->id);
        $this->assertEquals(4, $auctions->get(2)->id);
    }
    
    /**
     * @test
     */
    public function getActiceAuctionsForUser()
    {
        $this->_loadFixtures(array(
            'Category/1',
            'Category/3_parent_1',
            'Currency/1',
            
            'Auction/1_category_1_start_2012-05-02',
            'Auction/2_category_3_start_2012-05-05',
            'Auction/4_category_1_start_now-1', //not finished yet
            'Auction/5_category_1_start_2012-05-02_finished', //already finished
        ));
        
        $auctions = AuctionTable::getInstance()->getActiveAuctionsForUser(UserTable::getInstance()->find(1), 0, new Zend_Date('2012-05-03'));
        $this->assertEquals(2, count($auctions));
        $this->assertEquals(1, $auctions->get(0)->id);
        $this->assertEquals(5, $auctions->get(1)->id);
    }
}
