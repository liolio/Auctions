<?php
/**
 * @class Auctions_Form_User_RegistrationTest
 */
class Auctions_Form_User_RegistrationTest extends TestCase_Database
{
    
    /**
     * @var Auctions_Form_User_Registration
     */
    private $_form;
    
    protected function tearDown()
    {
        parent::tearDown();
        Auctions_Form_User_Registration::addReCaptcha();
    }
    
    protected function setUp()
    {
        Auctions_Form_User_Registration::addReCaptcha(false);
        parent::setUp();
        $this->_form = new Auctions_Form_User_Registration();
    }
    
    /**
     * @test
     */
    public function isValidWithValidValues()
    {
        $this->assertTrue($this->_form->isValid(array(
            FieldIdEnum::USER_LOGIN             =>  'login1',
            FieldIdEnum::USER_EMAIL             =>  'user@email.com',
            FieldIdEnum::ADDRESS_NAME           =>  'name',
            FieldIdEnum::ADDRESS_SURNAME        =>  'sur-name',
            FieldIdEnum::ADDRESS_STREET         =>  'street 1/1',
            FieldIdEnum::ADDRESS_POSTAL_CODE    =>  'postal 123',
            FieldIdEnum::ADDRESS_CITY           =>  'city',
            FieldIdEnum::ADDRESS_PROVINCE       =>  'province',
            FieldIdEnum::ADDRESS_COUNTRY        =>  'country',
            FieldIdEnum::ADDRESS_PHONE_NUMBER   =>  '123456890',
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
                    FieldIdEnum::USER_LOGIN             =>  '',
                    FieldIdEnum::USER_EMAIL             =>  '',
                    FieldIdEnum::ADDRESS_NAME           =>  '',
                    FieldIdEnum::ADDRESS_SURNAME        =>  '',
                    FieldIdEnum::ADDRESS_STREET         =>  '',
                    FieldIdEnum::ADDRESS_POSTAL_CODE    =>  '',
                    FieldIdEnum::ADDRESS_CITY           =>  '',
                    FieldIdEnum::ADDRESS_PROVINCE       =>  '',
                    FieldIdEnum::ADDRESS_COUNTRY        =>  '',
                    FieldIdEnum::ADDRESS_PHONE_NUMBER   =>  '',
                ),
                array(
                    FieldIdEnum::USER_LOGIN             =>  array(Zend_Validate_NotEmpty::IS_EMPTY),
                    FieldIdEnum::USER_EMAIL             =>  array(Zend_Validate_NotEmpty::IS_EMPTY),
                    FieldIdEnum::ADDRESS_NAME           =>  array(Zend_Validate_NotEmpty::IS_EMPTY),
                    FieldIdEnum::ADDRESS_SURNAME        =>  array(Zend_Validate_NotEmpty::IS_EMPTY),
                    FieldIdEnum::ADDRESS_STREET         =>  array(Zend_Validate_NotEmpty::IS_EMPTY),
                    FieldIdEnum::ADDRESS_POSTAL_CODE    =>  array(Zend_Validate_NotEmpty::IS_EMPTY),
                    FieldIdEnum::ADDRESS_CITY           =>  array(Zend_Validate_NotEmpty::IS_EMPTY),
                    FieldIdEnum::ADDRESS_PROVINCE       =>  array(Zend_Validate_NotEmpty::IS_EMPTY),
                    FieldIdEnum::ADDRESS_COUNTRY        =>  array(Zend_Validate_NotEmpty::IS_EMPTY),
                    FieldIdEnum::ADDRESS_PHONE_NUMBER   =>  array(Zend_Validate_NotEmpty::IS_EMPTY),
                    ParamIdEnum::FORM_NEXT_BUTTON       =>  array()
                )
            ),
            //too long
            array(
                array(
                    FieldIdEnum::USER_LOGIN             =>  str_repeat('a', 41),
                    FieldIdEnum::USER_EMAIL             =>  str_repeat('a', 101),
                    FieldIdEnum::ADDRESS_NAME           =>  str_repeat('a', 101),
                    FieldIdEnum::ADDRESS_SURNAME        =>  str_repeat('a', 101),
                    FieldIdEnum::ADDRESS_STREET         =>  str_repeat('a', 101),
                    FieldIdEnum::ADDRESS_POSTAL_CODE    =>  str_repeat('a', 101),
                    FieldIdEnum::ADDRESS_CITY           =>  str_repeat('a', 101),
                    FieldIdEnum::ADDRESS_PROVINCE       =>  str_repeat('a', 101),
                    FieldIdEnum::ADDRESS_COUNTRY        =>  str_repeat('a', 101),
                    FieldIdEnum::ADDRESS_PHONE_NUMBER   =>  str_repeat('a', 101),
                ),
                array(
                    FieldIdEnum::USER_LOGIN             =>  array(Zend_Validate_StringLength::TOO_LONG),
                    FieldIdEnum::USER_EMAIL             =>  array(Zend_Validate_StringLength::TOO_LONG),
                    FieldIdEnum::ADDRESS_NAME           =>  array(Zend_Validate_StringLength::TOO_LONG),
                    FieldIdEnum::ADDRESS_SURNAME        =>  array(Zend_Validate_StringLength::TOO_LONG),
                    FieldIdEnum::ADDRESS_STREET         =>  array(Zend_Validate_StringLength::TOO_LONG),
                    FieldIdEnum::ADDRESS_POSTAL_CODE    =>  array(Zend_Validate_StringLength::TOO_LONG),
                    FieldIdEnum::ADDRESS_CITY           =>  array(Zend_Validate_StringLength::TOO_LONG),
                    FieldIdEnum::ADDRESS_PROVINCE       =>  array(Zend_Validate_StringLength::TOO_LONG),
                    FieldIdEnum::ADDRESS_COUNTRY        =>  array(Zend_Validate_StringLength::TOO_LONG),
                    FieldIdEnum::ADDRESS_PHONE_NUMBER   =>  array(Zend_Validate_StringLength::TOO_LONG),
                    ParamIdEnum::FORM_NEXT_BUTTON       =>  array()
                )
            ),
            //invalid regex or alnum or alpha
            array(
                array(
                    FieldIdEnum::USER_LOGIN             =>  'admin1!@#',
                    FieldIdEnum::USER_EMAIL             =>  'invalid',
                    FieldIdEnum::ADDRESS_NAME           =>  'name132',
                    FieldIdEnum::ADDRESS_SURNAME        =>  'sur-name123',
                    FieldIdEnum::ADDRESS_STREET         =>  'street 1!',
                    FieldIdEnum::ADDRESS_POSTAL_CODE    =>  'postal+123',
                    FieldIdEnum::ADDRESS_CITY           =>  'city1',
                    FieldIdEnum::ADDRESS_PROVINCE       =>  'province1',
                    FieldIdEnum::ADDRESS_COUNTRY        =>  'country1',
                    FieldIdEnum::ADDRESS_PHONE_NUMBER   =>  '123456890p',
                ),
                array(
                    FieldIdEnum::USER_LOGIN             =>  array(Zend_Validate_Alnum::NOT_ALNUM),
                    FieldIdEnum::USER_EMAIL             =>  array(Zend_Validate_EmailAddress::INVALID_FORMAT),
                    FieldIdEnum::ADDRESS_NAME           =>  array(Zend_Validate_Alpha::NOT_ALPHA),
                    FieldIdEnum::ADDRESS_SURNAME        =>  array(Validate_Address_SurnameRegex::NOT_MATCH),
                    FieldIdEnum::ADDRESS_STREET         =>  array(Validate_Address_StreetRegex::NOT_MATCH),
                    FieldIdEnum::ADDRESS_POSTAL_CODE    =>  array(Validate_Address_PostalCodeRegex::NOT_MATCH),
                    FieldIdEnum::ADDRESS_CITY           =>  array(Zend_Validate_Alpha::NOT_ALPHA),
                    FieldIdEnum::ADDRESS_PROVINCE       =>  array(Zend_Validate_Alpha::NOT_ALPHA),
                    FieldIdEnum::ADDRESS_COUNTRY        =>  array(Zend_Validate_Alpha::NOT_ALPHA),
                    FieldIdEnum::ADDRESS_PHONE_NUMBER   =>  array(Validate_Address_PhoneNumberRegex::NOT_MATCH),
                    ParamIdEnum::FORM_NEXT_BUTTON       =>  array()
                )
            )
        );
    }
}
