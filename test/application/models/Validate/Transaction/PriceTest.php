<?php
/**
 * @class Validate_Transaction_PriceTest
 */
class Validate_Transaction_PriceTest extends TestCase_Database
{
    
    /**
     * @var Validate_Transaction_Price
     */
    private $_validator;
    
    protected function setUp()
    {
        parent::setUp();
        $this->_validator = new Validate_Transaction_Price();
    }
    
    /**
     * @test
     * @dataProvider dataProvider
     */
    public function isValid(array $fixtures, $transactionTypeName, $value, $expectedResult)
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
        $this->assertEquals(
            $expectedResult, 
            $this->_validator->isValid(
                $value, 
                array(
                    FieldIdEnum::AUCTION_ID             =>  5, 
                    FieldIdEnum::TRANSACTION_TYPE_NAME  =>  $transactionTypeName
                )
            )
        );
    }
    
    public function dataProvider()
    {
        return array(
                //no transactions
            array(array(), Enum_Db_TransactionType_Type::BIDDING, 122.12, true),    //equals to minimum price
            array(array(), Enum_Db_TransactionType_Type::BIDDING, 122.13, true),    //greater than minimum price
            array(array(), Enum_Db_TransactionType_Type::BIDDING, 122.11, false),   //lower than minimum price
            
                //bids
            array(array("Transaction/3_att_4_u_1", "Transaction/7_att_4_u_3"), Enum_Db_TransactionType_Type::BIDDING, 212.12, true),    //equals to minimum price
            array(array("Transaction/3_att_4_u_1", "Transaction/7_att_4_u_3"), Enum_Db_TransactionType_Type::BIDDING, 212.13, true),    //greater than minimum price
            array(array("Transaction/3_att_4_u_1", "Transaction/7_att_4_u_3"), Enum_Db_TransactionType_Type::BIDDING, 212.11, false),   //lower than minimum price

                //bids with one outbidded by bid
            array(array("Transaction/3_att_4_u_1", "Transaction/4_att_4_u_2", "Transaction/7_att_4_u_3"), Enum_Db_TransactionType_Type::BIDDING, 122.12, true),    //equals to minimum price
            array(array("Transaction/3_att_4_u_1", "Transaction/4_att_4_u_2", "Transaction/7_att_4_u_3"), Enum_Db_TransactionType_Type::BIDDING, 122.13, true),    //greater than minimum price
            array(array("Transaction/3_att_4_u_1", "Transaction/4_att_4_u_2", "Transaction/7_att_4_u_3"), Enum_Db_TransactionType_Type::BIDDING, 122.11, false),   //lower than minimum price
                
                //bids with one outbidded by buy out
            array(array("Transaction/3_att_4_u_1", "Transaction/5_att_5_u_1", "Transaction/7_att_4_u_3"), Enum_Db_TransactionType_Type::BIDDING, 2222.12, true),    //equals to minimum price
            array(array("Transaction/3_att_4_u_1", "Transaction/5_att_5_u_1", "Transaction/7_att_4_u_3"), Enum_Db_TransactionType_Type::BIDDING, 2222.13, true),    //greater than minimum price
            array(array("Transaction/3_att_4_u_1", "Transaction/5_att_5_u_1", "Transaction/7_att_4_u_3"), Enum_Db_TransactionType_Type::BIDDING, 2222.11, false),   //lower than minimum price

                //buy outs
            array(array(), Enum_Db_TransactionType_Type::BUY_OUT, 3210.12, true),   //equals to minimum price
            array(array(), Enum_Db_TransactionType_Type::BUY_OUT, 3210.13, true),    //greater than minimum price
            array(array(), Enum_Db_TransactionType_Type::BUY_OUT, 3210.11, false),    //lower than minimum price
        );
    }
}
