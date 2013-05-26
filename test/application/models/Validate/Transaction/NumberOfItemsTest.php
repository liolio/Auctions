<?php
/**
 * @class Validate_Transaction_NumberOfItemsTest
 */
class Validate_Transaction_NumberOfItemsTest extends TestCase_Database
{
    
    /**
     * @var Validate_Transaction_NumberOfItems
     */
    private $_validator;
    
    protected function setUp()
    {
        parent::setUp();
        $this->_validator = new Validate_Transaction_NumberOfItems();
    }
    
    /**
     * @test
     * @dataProvider dataProvider
     */
    public function isValid(array $fixtures, $value, $expectedResult)
    {
        $this->_loadFixtures(array(
            'Category/1',
            'Currency/1',
            'Auction/5_category_1_start_2012-05-02',
            'AuctionTransactionType/4_auction_5_tt_1',
            'AuctionTransactionType/5_auction_5_tt_2',
            'User/2'
        ));
        
        $this->_loadFixtures($fixtures);
        $this->assertEquals($expectedResult, $this->_validator->isValid($value, array(FieldIdEnum::AUCTION_ID => 5)));
    }
    
    public function dataProvider()
    {
        return array(
                //no transactions
            array(array(), 5, true),    //equals to number of items left
            array(array(), 6, false),   //greater than number of items left
            array(array(), 4, true),    //lower than number of items left
            
                //bids
            array(array('Transaction/3_att_4_u_1', 'Transaction/4_att_4_u_2'), 5, true),    //equals to number of items left
            array(array('Transaction/3_att_4_u_1', 'Transaction/4_att_4_u_2'), 6, false),   //greater than number of items left
            array(array('Transaction/3_att_4_u_1', 'Transaction/4_att_4_u_2'), 4, true),    //lower than number of items left

                //buy outs
            array(array('Transaction/5_att_5_u_1', 'Transaction/6_att_5_u_2'), 2, true),    //equals to number of items left
            array(array('Transaction/5_att_5_u_1', 'Transaction/6_att_5_u_2'), 3, false),   //greater than number of items left
            array(array('Transaction/5_att_5_u_1', 'Transaction/6_att_5_u_2'), 1, true),    //lower than number of items left
        );
    }
}
