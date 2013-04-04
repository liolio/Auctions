<?php
/**
 * @class Auctions_Form_Currency_AddTest
 */
class Auctions_Form_Currency_AddTest extends TestCase_Database
{
    
    /**
     * @var Auctions_Form_Currency_Add
     */
    private $_form;
    
    protected function setUp()
    {
        parent::setUp();
        $this->_loadFixture("Currency/1");
        $this->_form = new Auctions_Form_Currency_Add();
    }
    
    /**
     * @test
     */
    public function isValidWithValidValues()
    {
        $this->assertTrue($this->_form->isValid(array(
            FieldIdEnum::CURRENCY_NAME  =>  'EUR',
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
                    FieldIdEnum::CURRENCY_NAME      =>  '',
                ),
                array(
                    FieldIdEnum::CURRENCY_NAME      =>  array(Zend_Validate_NotEmpty::IS_EMPTY),
                    ParamIdEnum::FORM_ADD_BUTTON    =>  array()
                )
            ),
            //too long
            array(
                array(
                    FieldIdEnum::CURRENCY_NAME      =>  str_repeat('a', 101),
                ),
                array(
                    FieldIdEnum::CURRENCY_NAME      =>  array(Zend_Validate_StringLength::TOO_LONG),
                    ParamIdEnum::FORM_ADD_BUTTON    =>  array()
                )
            ),
            //invalid
            array(
                array(
                    FieldIdEnum::CURRENCY_NAME      =>  'PLN',
                ),
                array(
                    FieldIdEnum::CURRENCY_NAME      =>  array(Validate_Currency_NameUnique::NAME_EXISTS),
                    ParamIdEnum::FORM_ADD_BUTTON    =>  array()
                )
            )
        );
    }
}
