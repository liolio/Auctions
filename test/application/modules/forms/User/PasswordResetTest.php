<?php
/**
 * @class Auctions_Form_User_PasswordResetTest
 */
class Auctions_Form_User_PasswordResetTest extends TestCase_Database
{
    
    /**
     * @var Auctions_Form_User_Registration
     */
    private $_form;
    
    protected function setUp()
    {
        parent::setUp();
        $this->_form = new Auctions_Form_User_PasswordReset();
    }
    
    /**
     * @test
     */
    public function isValidWithValidValues()
    {
        $this->assertTrue($this->_form->isValid(array(
            FieldIdEnum::USER_EMAIL             =>  'lio_lio@wp.pl',
        )));
    }
    
    /**
     * @test
     * @dataProvider invalidValuesProvider
     */
    public function isValidWithInvalidValues($email, $error)
    {
        $this->assertFalse($this->_form->isValid(array(
            FieldIdEnum::USER_EMAIL =>  $email
        )));
        
        $this->assertEquals(
            array(
                FieldIdEnum::USER_EMAIL         =>  array($error),
                ParamIdEnum::FORM_NEXT_BUTTON   =>  array()
            ), 
            $this->_form->getErrors()
        );
    }
    
    public function invalidValuesProvider()
    {
        return array(
            array('', Zend_Validate_NotEmpty::IS_EMPTY),                                    //empty
            array(str_repeat('a', 101), Zend_Validate_StringLength::TOO_LONG),              //too long
            array('invalid', Zend_Validate_EmailAddress::INVALID_FORMAT),                   //invalid format
            array('non_existing@email.com', Validate_User_EmailExists::EMAIL_NOT_EXISTS),   //email not exists
        );
    }
}
