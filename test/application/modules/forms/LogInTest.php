<?php
/**
 * @class Auctions_Form_LogInTest
 */
class Auctions_Form_LogInTest extends TestCase_NoDatabase
{
    
    /**
     * @var Auctions_Form_LogIn
     */
    private $_form;
    
    protected function setUp()
    {
        parent::setUp();
        $this->_form = new Auctions_Form_LogIn();
    }
    
    /**
     * @test
     */
    public function isValidWithValidValues()
    {
        $this->assertTrue($this->_form->isValid(array(
            FieldIdEnum::USER_LOGIN     =>  'login',
            FieldIdEnum::USER_PASSWORD  =>  'password'
        )));
    }
    
    /**
     * @test
     * @dataProvider invalidValuesProvider
     */
    public function isValidWithInvalidValues($login, $password, array $errors)
    {
        $this->assertFalse($this->_form->isValid(array(
            FieldIdEnum::USER_LOGIN     =>  $login,
            FieldIdEnum::USER_PASSWORD  =>  $password
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
                    FieldIdEnum::USER_PASSWORD  =>  array(Zend_Validate_NotEmpty::IS_EMPTY),
                    ParamIdEnum::SUBMIT_BUTTON  =>  array()
                )
            ),
            //too long
            array(
                str_repeat('a', 41),
                str_repeat('a', 41),
                array(
                    FieldIdEnum::USER_LOGIN     =>  array(Zend_Validate_StringLength::TOO_LONG),
                    FieldIdEnum::USER_PASSWORD  =>  array(Zend_Validate_StringLength::TOO_LONG),
                    ParamIdEnum::SUBMIT_BUTTON  =>  array()
                )
            ),
            //invalid characters
            array(
                'inv!@$%^&*(alid',
                'password',
                array(
                    FieldIdEnum::USER_LOGIN     =>  array(Zend_Validate_Alnum::NOT_ALNUM),
                    FieldIdEnum::USER_PASSWORD  =>  array(),
                    ParamIdEnum::SUBMIT_BUTTON  =>  array()
                )
            ),
        );
    }
}
