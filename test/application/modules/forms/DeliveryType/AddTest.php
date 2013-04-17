<?php
/**
 * @class Auctions_Form_DeliveryType_AddTest
 */
class Auctions_Form_DeliveryType_AddTest extends TestCase_Database
{
    
    /**
     * @var Auctions_Form_DeliveryType_Add
     */
    private $_form;
    
    protected function setUp()
    {
        parent::setUp();
        $this->_loadFixture("DeliveryType/1");
        $this->_form = new Auctions_Form_DeliveryType_Add();
    }
    
    /**
     * @test
     */
    public function isValidWithValidValues()
    {
        $this->assertTrue($this->_form->isValid(array(
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
                    FieldIdEnum::DELIVERY_TYPE_NAME             =>  '',
                    FieldIdEnum::DELIVERY_TYPE_CASH_ON_DELIVERY =>  '',
                ),
                array(
                    FieldIdEnum::DELIVERY_TYPE_NAME             =>  array(Zend_Validate_NotEmpty::IS_EMPTY),
                    FieldIdEnum::DELIVERY_TYPE_CASH_ON_DELIVERY =>  array(),
                    ParamIdEnum::FORM_ADD_BUTTON                =>  array()
                )
            ),
            //too long
            array(
                array(
                    FieldIdEnum::DELIVERY_TYPE_NAME             =>  str_repeat('a', 101),
                    FieldIdEnum::DELIVERY_TYPE_CASH_ON_DELIVERY =>  '',
                ),
                array(
                    FieldIdEnum::DELIVERY_TYPE_NAME             =>  array(Zend_Validate_StringLength::TOO_LONG),
                    FieldIdEnum::DELIVERY_TYPE_CASH_ON_DELIVERY =>  array(),
                    ParamIdEnum::FORM_ADD_BUTTON                =>  array()
                )
            ),
            //invalid
            array(
                array(
                    FieldIdEnum::DELIVERY_TYPE_NAME             =>  'Kurier',
                    FieldIdEnum::DELIVERY_TYPE_CASH_ON_DELIVERY =>  '1',
                ),
                array(
                    FieldIdEnum::DELIVERY_TYPE_NAME             =>  array(Validate_DeliveryType_Unique::NOT_UNIQUE),
                    FieldIdEnum::DELIVERY_TYPE_CASH_ON_DELIVERY =>  array(),
                    ParamIdEnum::FORM_ADD_BUTTON                =>  array()
                )
            )
        );
    }
}
