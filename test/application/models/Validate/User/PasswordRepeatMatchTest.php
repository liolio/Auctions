<?php
/**
 * @class Validate_User_PasswordRepeatMatchTest
 */
class Validate_User_PasswordRepeatMatchTest extends TestCase_NoDatabase
{
    
    /**
     * @var Validate_User_PasswordMatch
     */
    private $_validator;
    
    protected function setUp()
    {
        parent::setUp();
        $this->_validator = new Validate_User_PasswordRepeatMatch();
    }
    
    /**
     * @test
     */
    public function isValidWithValidValues()
    {
        $this->assertTrue($this->_validator->isValid(
            "value",
            array(
                FieldIdEnum::USER_PASSWORD  =>  'value'
            )
        ));
    }
    
    /**
     * @test
     * @dataProvider invalidValuesProvider
     */
    public function isValidWithInvalidValues($value)
    {
        $this->assertFalse($this->_validator->isValid(
            $value,
            array(
                FieldIdEnum::USER_PASSWORD  =>  'value'
            )
        ));
    }
    
    public static function invalidValuesProvider()
    {
        return array(
            array('non_value'),
            array('')
        );
    }
}
