<?php
/**
 * @class Auctions_Form_BankingInformation_AddTest
 */
class Auctions_Form_BankingInformation_AddTest extends TestCase_Controller
{
    
    /**
     * @var Auctions_Form_BankingInformation_Add
     */
    private $_form;
    
    protected function setUp()
    {
        parent::setUp();
        
        Fixture_Loader::create("Currency/1");
        Fixture_Loader::create("BankingInformation/1_currency_1_user_1");
        
        $this->_form = new Auctions_Form_BankingInformation_Add();
    }
    
    /**
     * @test
     */
    public function isValidWithValidValues()
    {
        $this->assertTrue($this->_form->isValid(array(
            FieldIdEnum::BANKING_INFORMATION_ACCOUNT_NUMBER =>  '1234',
            FieldIdEnum::BANKING_INFORMATION_BANK_NAME      =>  'super bank',
            FieldIdEnum::BANKING_INFORMATION_CURRENCY_ID    =>  '1'
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
                    FieldIdEnum::BANKING_INFORMATION_ACCOUNT_NUMBER =>  '',
                    FieldIdEnum::BANKING_INFORMATION_BANK_NAME      =>  '',
                    FieldIdEnum::BANKING_INFORMATION_CURRENCY_ID    =>  ''
                ),
                array(
                    FieldIdEnum::BANKING_INFORMATION_ACCOUNT_NUMBER =>  array(Zend_Validate_NotEmpty::IS_EMPTY),
                    FieldIdEnum::BANKING_INFORMATION_BANK_NAME      =>  array(Zend_Validate_NotEmpty::IS_EMPTY),
                    FieldIdEnum::BANKING_INFORMATION_CURRENCY_ID    =>  array(Zend_Validate_NotEmpty::IS_EMPTY),
                    ParamIdEnum::FORM_ADD_BUTTON                    =>  array()
                )
            ),
            //too long
            array(
                array(
                    FieldIdEnum::BANKING_INFORMATION_ACCOUNT_NUMBER =>  str_repeat('a', 101),
                    FieldIdEnum::BANKING_INFORMATION_BANK_NAME      =>  str_repeat('a', 256),
                    FieldIdEnum::BANKING_INFORMATION_CURRENCY_ID    =>  '1',
                ),
                array(
                    FieldIdEnum::BANKING_INFORMATION_ACCOUNT_NUMBER =>  array(Validate_StringLength::TOO_LONG),
                    FieldIdEnum::BANKING_INFORMATION_BANK_NAME      =>  array(Validate_StringLength::TOO_LONG),
                    FieldIdEnum::BANKING_INFORMATION_CURRENCY_ID    =>  array(),
                    ParamIdEnum::FORM_ADD_BUTTON                =>  array()
                )
            ),
            //invalid format
            array(
                array(
                    FieldIdEnum::BANKING_INFORMATION_ACCOUNT_NUMBER =>  "1234",
                    FieldIdEnum::BANKING_INFORMATION_BANK_NAME      =>  "super bank",
                    FieldIdEnum::BANKING_INFORMATION_CURRENCY_ID    =>  '-1',
                ),
                array(
                    FieldIdEnum::BANKING_INFORMATION_ACCOUNT_NUMBER =>  array(),
                    FieldIdEnum::BANKING_INFORMATION_BANK_NAME      =>  array(),
                    FieldIdEnum::BANKING_INFORMATION_CURRENCY_ID    =>  array(Zend_Validate_InArray::NOT_IN_ARRAY),
                    ParamIdEnum::FORM_ADD_BUTTON                    =>  array()
                )
            ),
            //invalid already exists
            array(
                array(
                    FieldIdEnum::BANKING_INFORMATION_ACCOUNT_NUMBER =>  "123 432 6456 7657",
                    FieldIdEnum::BANKING_INFORMATION_BANK_NAME      =>  "polski bank",
                    FieldIdEnum::BANKING_INFORMATION_CURRENCY_ID    =>  '1',
                ),
                array(
                    FieldIdEnum::BANKING_INFORMATION_ACCOUNT_NUMBER =>  array(Validate_BankingInformation_AccountNumberUnique::NOT_UNIQUE),
                    FieldIdEnum::BANKING_INFORMATION_BANK_NAME      =>  array(),
                    FieldIdEnum::BANKING_INFORMATION_CURRENCY_ID    =>  array(),
                    ParamIdEnum::FORM_ADD_BUTTON                    =>  array()
                )
            )
        );
    }
}
