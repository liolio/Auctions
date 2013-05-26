<?php
/**
 * @class AuctionTransactionTypeTest
 */
class AuctionTransactionTypeTest extends TestCase_Database
{
    
    /**
     * @test
     * @dataProvider countPriceTestDataProvider
     */
    public function countPriceTest(array $fixtures, $transactionTypeName, $expectedResult)
    {
        $this->_loadFixtures(array(
            'Category/1',
            'Currency/1',
            'Auction/5_category_1_start_2012-05-02',
            'AuctionTransactionType/4_auction_5_tt_1',
            'AuctionTransactionType/5_auction_5_tt_2',
            'User/2',
            'User/3_inactive'
        ));
        
        $this->_loadFixtures($fixtures);
        
        $this->assertEquals($expectedResult,
            AuctionTransactionTypeTable::getInstance()->getAuctionTransactionType(AuctionTable::getInstance()->find(5), $transactionTypeName)->countPrice()
        );
    }
    
    public function countPriceTestDataProvider()
    {
        return array(
            array(array(), Enum_Db_TransactionType_Type::BIDDING, 122.12),    //no transactions
            array(array(), Enum_Db_TransactionType_Type::BUY_OUT, 3210.12),   //no transactions
            array(array("Transaction/3_att_4_u_1", "Transaction/7_att_4_u_3"), Enum_Db_TransactionType_Type::BIDDING, 212.12),    //bids
            array(array("Transaction/3_att_4_u_1", "Transaction/4_att_4_u_2", "Transaction/7_att_4_u_3"), Enum_Db_TransactionType_Type::BIDDING, 122.12),   //bids with one outbidded by bid
            array(array("Transaction/3_att_4_u_1", "Transaction/5_att_5_u_1", "Transaction/7_att_4_u_3"), Enum_Db_TransactionType_Type::BIDDING, 2222.12),  //bids with one outbidded by buy out
        );
    }

    /**
     * @test
     */
    public function getItemsToShowBuyOut()
    {
        $this->_loadFixtures(array(
            'Category/1',
            'Currency/1',
            'Auction/5_category_1_start_2012-05-02',
            'AuctionTransactionType/5_auction_5_tt_2',
            'User/2',
            'Transaction/6_att_5_u_2'
        ));
        
        $items = AuctionTransactionTypeTable::getInstance()
                ->getAuctionTransactionType(AuctionTable::getInstance()->find(5), Enum_Db_TransactionType_Type::BUY_OUT)->getItemsToShow();
        
        $this->assertEquals(1, count($items));
        $this->assertEquals(2, $items->get(0)->User->id);
    }

    /**
     * @test
     * @dataProvider getItemsToShowBiddingDataProvider
     */
    public function getItemsToShowBidding(array $fixtures, $expectedValidResultIds, $expectedInvalidResultIds)
    {
        $this->_loadFixtures(array(
            'Category/1',
            'Currency/1',
            'Auction/5_category_1_start_2012-05-02',
            'AuctionTransactionType/4_auction_5_tt_1',
            'AuctionTransactionType/5_auction_5_tt_2',
            'User/2',
            'User/3_inactive'
        ));
        
        $this->_loadFixtures($fixtures);
        
        $items = AuctionTransactionTypeTable::getInstance()
                ->getAuctionTransactionType(AuctionTable::getInstance()->find(5), Enum_Db_TransactionType_Type::BIDDING)->getItemsToShow();
        
        $validIds = array();
        $invalidIds = array();
        
        foreach ($items[ParamIdEnum::TRANSACTION_VALID] as $transaction)
            $validIds[] = $transaction->id;
 
        foreach ($items[ParamIdEnum::TRANSACTION_INVALID] as $transaction)
            $invalidIds[] = $transaction->id;
        
        $this->assertEquals($expectedValidResultIds, $validIds);
        $this->assertEquals($expectedInvalidResultIds, $invalidIds);
    }
    
    public function getItemsToShowBiddingDataProvider()
    {
        return array(
            array(array(), array(), array()),    //no transactions
            array(array("Transaction/3_att_4_u_1", "Transaction/7_att_4_u_3"), array(7, 3), array()),    //bids
            array(array("Transaction/3_att_4_u_1", "Transaction/4_att_4_u_2", "Transaction/7_att_4_u_3"), array(7, 4), array(3)),   //bids with one outbidded by bid
            array(array("Transaction/3_att_4_u_1", "Transaction/5_att_5_u_1", "Transaction/7_att_4_u_3"), array(7), array(3)),      //bids with one outbidded by buy out
        );
    }
}
