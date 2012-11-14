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
    
    protected function setUp()
    {
        parent::setUp();
        $this->_form = new Auctions_Form_User_Registration();
    }
    
    /**
     * @test
     */
    public function isValidWithValidValues()
    {
        $this->assertTrue($this->_form->isValid(array(
            FieldIdEnum::USER_LOGIN =>  'login',
            FieldIdEnum::USER_EMAIL =>  'user@email.com'
        )));
    }
    
    /**
     * @test
     * @dataProvider invalidValuesProvider
     */
    public function isValidWithInvalidValues($login, $email, array $errors)
    {
        $this->assertFalse($this->_form->isValid(array(
            FieldIdEnum::USER_LOGIN =>  $login,
            FieldIdEnum::USER_EMAIL =>  $email
        )));
        
        $this->assertEquals($errors, $this->_form->getErrors());
    }
    
    public function invalidValuesProvider()
    {
        return array(
            //empty
            array(
                '',
                '',
                array(
                    FieldIdEnum::USER_LOGIN     =>  array(Zend_Validate_NotEmpty::IS_EMPTY),
                    FieldIdEnum::USER_EMAIL     =>  array(Zend_Validate_NotEmpty::IS_EMPTY),
                    ParamIdEnum::SUBMIT_BUTTON  =>  array()
                )
            ),
            //too long
            array(
                str_repeat('a', 41),
                str_repeat('a', 101),
                array(
                    FieldIdEnum::USER_LOGIN     =>  array(Zend_Validate_StringLength::TOO_LONG),
                    FieldIdEnum::USER_EMAIL     =>  array(Zend_Validate_StringLength::TOO_LONG),
                    ParamIdEnum::SUBMIT_BUTTON  =>  array()
                )
            ),
            //not unique
            array(
                'admin',
                'lio_lio@wp.pl',
                array(
                    FieldIdEnum::USER_LOGIN     =>  array(Validate_User_LoginUnique::LOGIN_EXISTS),
                    FieldIdEnum::USER_EMAIL     =>  array(Validate_User_EmailUnique::EMAIL_EXISTS),
                    ParamIdEnum::SUBMIT_BUTTON  =>  array()
                )
            ),
            //invalid
            array(
                'login',
                'invalid!@#$%^&*()_',
                array(
                    FieldIdEnum::USER_LOGIN     =>  array(),
                    FieldIdEnum::USER_EMAIL     =>  array(
                        Zend_Validate_EmailAddress::INVALID_HOSTNAME,
                        Zend_Validate_Hostname::INVALID_HOSTNAME,
                        Zend_Validate_Hostname::INVALID_LOCAL_NAME,
                    ),
                    ParamIdEnum::SUBMIT_BUTTON  =>  array()
                )
            )
        );
    }
}
