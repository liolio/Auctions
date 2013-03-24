<?php
/**
 * @class Auctions_Form_User_SetPasswordTest
 */
class Auctions_Form_User_SetPasswordTest extends TestCase_NoDatabase
{
    
    /**
     * @var Auctions_Form_User_SetPassword
     */
    private $_form;
    
    protected function setUp()
    {
        parent::setUp();
        $this->_form = new Auctions_Form_User_SetPassword();
    }
    
    /**
     * @test
     */
    public function isValidWithValidValues()
    {
        $this->assertTrue($this->_form->isValid(array(
            FieldIdEnum::USER_LOGIN         =>  'login',
            FieldIdEnum::USER_PASSWORD      =>  'password',
            ParamIdEnum::PASSWORD_REPEAT    =>  'password'
        )));
    }
    
    /**
     * @test
     * @dataProvider invalidValuesProvider
     */
    public function isValidWithInvalidValues($login, $password, $passwordRepeat, array $errors)
    {
        $this->assertFalse($this->_form->isValid(array(
            FieldIdEnum::USER_LOGIN         =>  $login,
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
                array(
                    FieldIdEnum::USER_LOGIN         =>  array(Zend_Validate_NotEmpty::IS_EMPTY),
                    FieldIdEnum::USER_PASSWORD      =>  array(Zend_Validate_NotEmpty::IS_EMPTY),
                    ParamIdEnum::PASSWORD_REPEAT    =>  array(Zend_Validate_NotEmpty::IS_EMPTY),
                    ParamIdEnum::SUBMIT_BUTTON      =>  array()
                )
            ),
            //too long
            array(
                'not_long',
                str_repeat('a', 41),
                str_repeat('a', 41),
                array(
                    FieldIdEnum::USER_LOGIN         =>  array(),
                    FieldIdEnum::USER_PASSWORD      =>  array(Zend_Validate_StringLength::TOO_LONG),
                    ParamIdEnum::PASSWORD_REPEAT    =>  array(Zend_Validate_StringLength::TOO_LONG),
                    ParamIdEnum::SUBMIT_BUTTON      =>  array()
                )
            ),
            //password not match
            array(
                'not_long',
                'password',
                'password_not_matching',
                array(
                    FieldIdEnum::USER_LOGIN         =>  array(),
                    FieldIdEnum::USER_PASSWORD      =>  array(),
                    ParamIdEnum::PASSWORD_REPEAT    =>  array(Validate_User_PasswordRepeatMatch::PASSWORD_NOT_MATCH),
                    ParamIdEnum::SUBMIT_BUTTON      =>  array()
                )
            ),
        );
    }
}
