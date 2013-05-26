<?php
/**
 * @class TransactionTableTest
 */
class TransactionTableTest extends TestCase_Database
{
    
    /**
     * @test
     * @dataProvider getNumberOfItemsLeftForAuctionAndTransactionTypeNameDataProvider
     */
    public function getNumberOfItemsLeftForAuctionAndTransactionTypeName(array $fixtures, $expectedResult)
    {
        $this->_loadFixtures(array(
            'Category/1',
            'Currency/1',
            'Auction/1_category_1_start_2012-05-02',
            'User/2',
            'AuctionTransactionType/2_auction_1_tt_1',
        ));
        $this->_loadFixtures($fixtures);
        
        $this->assertEquals($expectedResult, TransactionTable::getInstance()->getNumberOfItemsLeftForAuctionAndTransactionTypeName(
            AuctionTable::getInstance()->find(1)));
    }
    
    public function getNumberOfItemsLeftForAuctionAndTransactionTypeNameDataProvider()
    {
        return array(
            array(
                array(
                    'Transaction/1_att_2_u_1',
                    'Transaction/2_att_2_u_2',
                ),
                -6
            ),
            array(
                array(),
                1
            )
        );
    }
    
    /**
     * @test
     */
    public function getBiddingsForAuction()
    {
        $this->_loadFixtures(array(
            'Category/1',
            'Currency/1',
            'Auction/5_category_1_start_2012-05-02',
            'AuctionTransactionType/4_auction_5_tt_1',
            'User/2',
            'User/3_inactive',
            'Transaction/3_att_4_u_1',
            'Transaction/4_att_4_u_2',
            'Transaction/7_att_4_u_3',
        ));
        
        $biddings = TransactionTable::getInstance()->getBiddingsForAuction(AuctionTable::getInstance()->find(5));
        
        $this->assertEquals(3, count($biddings));
        $this->assertEquals(3, $biddings->get(0)->User->id);
        $this->assertEquals(2, $biddings->get(1)->User->id);
        $this->assertEquals(1, $biddings->get(2)->User->id);
    }
}
