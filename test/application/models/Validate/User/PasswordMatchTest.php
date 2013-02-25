<?php
/**
 * @class Validate_User_PasswordMatchTest
 */
class Validate_User_PasswordMatchTest extends TestCase_Database
{
    
    /**
     * @var Validate_User_PasswordMatch
     */
    private $_validator;
    
    protected function setUp()
    {
        parent::setUp();
        $this->_validator = new Validate_User_PasswordMatch();
    }
    
    /**
     * @test
     */
    public function isValidWithValidValues()
    {
        die;
        $this->assertTrue($this->_validator->isValid(
            'admin', 
            array(
                FieldIdEnum::USER_LOGIN =>  'admin'
            )
        ));
    }
    
    /**
     * @test
     * @dataProvider invalidValuesProvider
     */
    public function isValidWithInvalidValues($value, $userName)
    {
        $this->assertFalse($this->_validator->isValid(
            $value, 
            array(
                FieldIdEnum::USER_LOGIN =>  'admin'
            )
        ));
    }
    
    public static function invalidValuesProvider()
    {
        return array(
            array('invalid', 'invalid'),    //invalid password, invalid username
            array('admin', 'invalid'),      //valid password, invalid username
            array('invalid', 'admin'),      //invalid password, valid username
            array('', 'admin')              //empty password, valid username
        );
    }
}
