<?php
/**
 * @class AuctionTransactionTypeTableTest
 */
class AuctionTransactionTypeTableTest extends TestCase_Database
{
    
    /**
     * @test
     * @dataProvider getAuctionTransactionTypeDataProvider
     */
    public function getAuctionTransactionType($transactionTypeName, $expectedId)
    {
        $this->_loadFixtures(array(
            'Category/1',
            'Currency/1',
            'Auction/5_category_1_start_2012-05-02',
            'AuctionTransactionType/4_auction_5_tt_1',
            'AuctionTransactionType/5_auction_5_tt_2',
        ));
        
        $this->assertEquals(
            $expectedId,
            AuctionTransactionTypeTable::getInstance()->getAuctionTransactionType(AuctionTable::getInstance()->find(5), $transactionTypeName)->id
        );
    }
    
    public function getAuctionTransactionTypeDataProvider()
    {
        return array(
            array(Enum_Db_TransactionType_Type::BIDDING, 4),
            array(Enum_Db_TransactionType_Type::BUY_OUT, 5)
        );
    }
    
}
