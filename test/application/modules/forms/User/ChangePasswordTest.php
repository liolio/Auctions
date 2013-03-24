<?php
/**
 * @class Auctions_Form_User_ChangePasswordTest
 */
class Auctions_Form_User_ChangePasswordTest extends TestCase_Database
{
    
    /**
     * @var Auctions_Form_User_ChangePassword
     */
    private $_form;
    
    protected function setUp()
    {
        parent::setUp();
        $this->_form = new Auctions_Form_User_ChangePassword();
    }
    
    /**
     * @test
     */
    public function isValidWithValidValues()
    {
        $this->assertTrue($this->_form->isValid(array(
            FieldIdEnum::USER_LOGIN         =>  'admin',
            ParamIdEnum::OLD_PASSWORD       =>  'admin',
            FieldIdEnum::USER_PASSWORD      =>  'new_admin',
            ParamIdEnum::PASSWORD_REPEAT    =>  'new_admin'
        )));
    }
    
    /**
     * @test
     * @dataProvider invalidValuesProvider
     */
    public function isValidWithInvalidValues($login, $oldPassword, $password, $passwordRepeat, array $errors)
    {
        $this->assertFalse($this->_form->isValid(array(
            FieldIdEnum::USER_LOGIN         =>  $login,
            ParamIdEnum::OLD_PASSWORD       =>  $oldPassword,
            FieldIdEnum::USER_PASSWORD      =>  $password,
            ParamIdEnum::PASSWORD_REPEAT    =>  $passwordRepeat
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
                '',
                '',
                array(
                    FieldIdEnum::USER_LOGIN         =>  array(Zend_Validate_NotEmpty::IS_EMPTY),
                    ParamIdEnum::OLD_PASSWORD       =>  array(Zend_Validate_NotEmpty::IS_EMPTY),
                    FieldIdEnum::USER_PASSWORD      =>  array(Zend_Validate_NotEmpty::IS_EMPTY),
                    ParamIdEnum::PASSWORD_REPEAT    =>  array(Zend_Validate_NotEmpty::IS_EMPTY),
                    ParamIdEnum::SUBMIT_BUTTON      =>  array()
                )
            ),
            //too long
            array(
                'admin',
                str_repeat('a', 41),
                str_repeat('a', 41),
                str_repeat('a', 41),
                array(
                    FieldIdEnum::USER_LOGIN         =>  array(),
                    ParamIdEnum::OLD_PASSWORD       =>  array(Zend_Validate_StringLength::TOO_LONG),
                    FieldIdEnum::USER_PASSWORD      =>  array(Zend_Validate_StringLength::TOO_LONG),
                    ParamIdEnum::PASSWORD_REPEAT    =>  array(Zend_Validate_StringLength::TOO_LONG),
                    ParamIdEnum::SUBMIT_BUTTON      =>  array()
                )
            ),
            //password repeat not match
            array(
                'admin',
                'admin',
                'password',
                'password_not_matching',
                array(
                    FieldIdEnum::USER_LOGIN         =>  array(),
                    ParamIdEnum::OLD_PASSWORD       =>  array(),
                    FieldIdEnum::USER_PASSWORD      =>  array(),
                    ParamIdEnum::PASSWORD_REPEAT    =>  array(Validate_User_PasswordRepeatMatch::PASSWORD_NOT_MATCH),
                    ParamIdEnum::SUBMIT_BUTTON      =>  array()
                )
            ),
            //old password not match
            array(
                'admin',
                'admin2',
                'password',
                'password',
                array(
                    FieldIdEnum::USER_LOGIN         =>  array(),
                    ParamIdEnum::OLD_PASSWORD       =>  array(Validate_User_PasswordMatch::PASSWORD_NOT_MATCH),
                    FieldIdEnum::USER_PASSWORD      =>  array(),
                    ParamIdEnum::PASSWORD_REPEAT    =>  array(),
                    ParamIdEnum::SUBMIT_BUTTON      =>  array()
                )
            ),
        );
    }
}
