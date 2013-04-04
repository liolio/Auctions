<?php
/**
 * @class Auctions_Form_Currency_EditTest
 */
class Auctions_Form_Currency_EditTest extends TestCase_Database
{
    
    /**
     * @var Auctions_Form_Currency_Add
     */
    private $_form;
    
    protected function setUp()
    {
        parent::setUp();
        $this->_loadFixture("Currency/1");
        $this->_form = new Auctions_Form_Currency_Edit();
    }

    /**
     * @test
     * @dataProvider validValuesProvider
     */
    public function isValidWithValidValues(array $data)
    {
        $this->assertTrue($this->_form->isValid($data));
    }
    
    /**
     * @test
     */
    public function validValuesProvider()
    {
        return array(
            array(array(
                FieldIdEnum::CURRENCY_ID    =>  '1',
                FieldIdEnum::CURRENCY_NAME  =>  'PLN',
            )),
            array(array(
                FieldIdEnum::CURRENCY_ID    =>  '1',
                FieldIdEnum::CURRENCY_NAME  =>  'EUR',
            )),
            array(array(
                FieldIdEnum::CURRENCY_ID    =>  '2',
                FieldIdEnum::CURRENCY_NAME  =>  'EUR',
            )),
        );
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
                    FieldIdEnum::CURRENCY_ID        =>  '',
                    FieldIdEnum::CURRENCY_NAME      =>  '',
                ),
                array(
                    FieldIdEnum::CURRENCY_ID        =>  array(Zend_Validate_NotEmpty::IS_EMPTY),
                    FieldIdEnum::CURRENCY_NAME      =>  array(Zend_Validate_NotEmpty::IS_EMPTY),
                    ParamIdEnum::FORM_EDIT_BUTTON   =>  array()
                )
            ),
            //too long
            array(
                array(
                    FieldIdEnum::CURRENCY_ID      =>  '1',
                    FieldIdEnum::CURRENCY_NAME      =>  str_repeat('a', 101),
                ),
                array(
                    FieldIdEnum::CURRENCY_ID        =>  array(),
                    FieldIdEnum::CURRENCY_NAME      =>  array(Zend_Validate_StringLength::TOO_LONG),
                    ParamIdEnum::FORM_EDIT_BUTTON   =>  array()
                )
            ),
            //invalid name
            array(
                array(
                    FieldIdEnum::CURRENCY_ID        =>  '2',
                    FieldIdEnum::CURRENCY_NAME      =>  'PLN',
                ),
                array(
                    FieldIdEnum::CURRENCY_ID        =>  array(),
                    FieldIdEnum::CURRENCY_NAME      =>  array(Validate_Currency_NameUnique::NAME_EXISTS),
                    ParamIdEnum::FORM_EDIT_BUTTON   =>  array()
                )
            ),
            //invalid id
            array(
                array(
                    FieldIdEnum::CURRENCY_ID        =>  'asd',
                    FieldIdEnum::CURRENCY_NAME      =>  'EUR',
                ),
                array(
                    FieldIdEnum::CURRENCY_ID        =>  array(Zend_Validate_Int::NOT_INT),
                    FieldIdEnum::CURRENCY_NAME      =>  array(),
                    ParamIdEnum::FORM_EDIT_BUTTON   =>  array()
                )
            )
        );
    }
}
