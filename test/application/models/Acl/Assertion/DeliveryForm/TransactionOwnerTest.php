<?php
/**
 * @class Acl_Assertion_DeliveryForm_TransactionOwnerTest
 */
class Acl_Assertion_DeliveryForm_TransactionOwnerTest extends TestCase_Controller
{
    
    /**
     * @var Zend_Acl
     */
    private $_acl;

    protected function setUp()
    {
        parent::setUp();
        $this->_acl = new Zend_Acl();
    }

    /**
     * @test
     * @dataProvider dataProvider
     */
    public function assertWithValidData(array $fixtures, $result)
    {
        $this->_loadFixtures($fixtures);
        
        $assertion = new Acl_Assertion_DeliveryForm_TransactionOwner(array(FieldIdEnum::DELIVERY_FORM_ID => '1'));
        $this->assertEquals($result, $assertion->assert($this->_acl));
    }
    
    public static function dataProvider()
    {
        return array(
            array(
                array(
                    'Currency/1',
                    'Category/1',
                    'Auction/1_category_1_start_2012-05-02',
                    'AuctionTransactionType/2_auction_1_tt_1',
                    'Transaction/1_att_2_u_1',
                    'DeliveryForm/1_transaction_1_to_fill',
                ),
                true
            ),
            array(
                array(
                    'Currency/1',
                    'Category/1',
                    'Auction/5_category_1_start_2012-05-02',
                    'AuctionTransactionType/5_auction_5_tt_2',
                    'User/2',
                    'Transaction/6_att_5_u_2',
                    'DeliveryForm/1_transaction_6_to_fill',
                ),
                true
            ),
        );
    }     
}
