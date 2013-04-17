<?php
/**
 * @class Auctions_Form_DeliveryType_EditTest
 */
class Auctions_Form_DeliveryType_EditTest extends TestCase_Database
{
    
    /**
     * @var Auctions_Form_DeliveryType_Edit
     */
    private $_form;
    
    protected function setUp()
    {
        parent::setUp();
        
        $this->_loadFixtures(array(
            "DeliveryType/1",
            "DeliveryType/2"
        ));
        
        $this->_form = new Auctions_Form_DeliveryType_Edit();
    }
    
    /**
     * @test
     */
    public function isValidWithValidValues()
    {
        $this->assertTrue($this->_form->isValid(array(
            FieldIdEnum::DELIVERY_TYPE_ID               =>  '1',
            FieldIdEnum::DELIVERY_TYPE_NAME             =>  'name',
            FieldIdEnum::DELIVERY_TYPE_CASH_ON_DELIVERY =>  '0',
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
                    FieldIdEnum::DELIVERY_TYPE_ID               =>  '',
                    FieldIdEnum::DELIVERY_TYPE_NAME             =>  '',
                    FieldIdEnum::DELIVERY_TYPE_CASH_ON_DELIVERY =>  '',
                ),
                array(
                    FieldIdEnum::DELIVERY_TYPE_ID               =>  array(Zend_Validate_NotEmpty::IS_EMPTY),
                    FieldIdEnum::DELIVERY_TYPE_NAME             =>  array(Zend_Validate_NotEmpty::IS_EMPTY),
                    FieldIdEnum::DELIVERY_TYPE_CASH_ON_DELIVERY =>  array(),
                    ParamIdEnum::FORM_EDIT_BUTTON                =>  array()
                )
            ),
            //too long
            array(
                array(
                    FieldIdEnum::DELIVERY_TYPE_ID               =>  '1',
                    FieldIdEnum::DELIVERY_TYPE_NAME             =>  str_repeat('a', 101),
                    FieldIdEnum::DELIVERY_TYPE_CASH_ON_DELIVERY =>  '',
                ),
                array(
                    FieldIdEnum::DELIVERY_TYPE_ID               =>  array(),
                    FieldIdEnum::DELIVERY_TYPE_NAME             =>  array(Zend_Validate_StringLength::TOO_LONG),
                    FieldIdEnum::DELIVERY_TYPE_CASH_ON_DELIVERY =>  array(),
                    ParamIdEnum::FORM_EDIT_BUTTON                =>  array()
                )
            ),
            //invalid
            array(
                array(
                    FieldIdEnum::DELIVERY_TYPE_ID               =>  '1',
                    FieldIdEnum::DELIVERY_TYPE_NAME             =>  'Poczta polska',
                    FieldIdEnum::DELIVERY_TYPE_CASH_ON_DELIVERY =>  '0',
                ),
                array(
                    FieldIdEnum::DELIVERY_TYPE_ID               =>  array(),
                    FieldIdEnum::DELIVERY_TYPE_NAME             =>  array(Validate_DeliveryType_Unique::NOT_UNIQUE),
                    FieldIdEnum::DELIVERY_TYPE_CASH_ON_DELIVERY =>  array(),
                    ParamIdEnum::FORM_EDIT_BUTTON                =>  array()
                )
            )
        );
    }
}
