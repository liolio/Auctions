<?php
/**
 * @class Auctions_Form_DeliveryForm_AddTest
 */
class Auctions_Form_DeliveryForm_AddTest extends TestCase_Database
{
    
    /**
     * @var Auctions_Form_DeliveryForm_Add
     */
    private $_form;
    
    protected function setUp()
    {
        parent::setUp();
        
        $this->_loadFixtures(array(
            'Currency/1',
            'Category/1',
            'Auction/1_category_1_start_2012-05-02',
            'AuctionTransactionType/2_auction_1_tt_1',
            'Transaction/1_att_2_u_1',
            'DeliveryType/1',
            'Delivery/1_delivery_type_1_auction_1',
            'DeliveryForm/1_transaction_1_to_fill',
        ));
        
        $this->_form = new Auctions_Form_DeliveryForm_Add(DeliveryFormTable::getInstance()->find(1));
    }
    
    /**
     * @test
     */
    public function isValidWithValidValues()
    {
        $this->assertTrue($this->_form->isValid(array(
            FieldIdEnum::DELIVERY_FORM_ID           =>  '1',
            FieldIdEnum::DELIVERY_FORM_ADDRESS_ID   =>  '1',
            FieldIdEnum::DELIVERY_FORM_DELIVERY_ID  =>  '1',
            FieldIdEnum::DELIVERY_FORM_COMMENT      =>  'comment 1',
        )));
    }
    
    /**
     * @test
     * @dataProvider invalidValuesProvider
     */
    public function isValidWithInvalidValues(array $data, array $errors)
    {
        $this->assertFalse($this->_form->isValid($data));
        
        $this->assertEquals($errors, $this->_form->getErrors());
    }
    
    public function invalidValuesProvider()
    {
        return array(
            //empty
            array(
                array(
                    FieldIdEnum::DELIVERY_FORM_ID           =>  '',
                    FieldIdEnum::DELIVERY_FORM_ADDRESS_ID   =>  '',
                    FieldIdEnum::DELIVERY_FORM_DELIVERY_ID  =>  '',
                    FieldIdEnum::DELIVERY_FORM_COMMENT      =>  '',
                ),
                array(
                    FieldIdEnum::DELIVERY_FORM_ID           =>  array(Zend_Validate_NotEmpty::IS_EMPTY),
                    FieldIdEnum::DELIVERY_FORM_ADDRESS_ID   =>  array(Zend_Validate_NotEmpty::IS_EMPTY),
                    FieldIdEnum::DELIVERY_FORM_DELIVERY_ID  =>  array(Zend_Validate_NotEmpty::IS_EMPTY),
                    FieldIdEnum::DELIVERY_FORM_COMMENT      =>  array(),
                    ParamIdEnum::FORM_SAVE_BUTTON           =>  array()
                )
            ),
            //invalid
            array(
                array(
                    FieldIdEnum::DELIVERY_FORM_ID           =>  'one',
                    FieldIdEnum::DELIVERY_FORM_ADDRESS_ID   =>  'one',
                    FieldIdEnum::DELIVERY_FORM_DELIVERY_ID  =>  'one',
                    FieldIdEnum::DELIVERY_FORM_COMMENT      =>  'one',
                ),
                array(
                    FieldIdEnum::DELIVERY_FORM_ID           =>  array(Validate_Int::NOT_INT),
                    FieldIdEnum::DELIVERY_FORM_ADDRESS_ID   =>  array(Zend_Validate_InArray::NOT_IN_ARRAY),
                    FieldIdEnum::DELIVERY_FORM_DELIVERY_ID  =>  array(Zend_Validate_InArray::NOT_IN_ARRAY),
                    FieldIdEnum::DELIVERY_FORM_COMMENT      =>  array(),
                    ParamIdEnum::FORM_SAVE_BUTTON           =>  array()
                )
            ),
        );
    }
}
