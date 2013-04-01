<?php
/**
 * @class Validate_User_LoginUniqueTest
 */
class Validate_User_LoginUniqueTest extends TestCase_Database
{
    
    /**
     * @var Validate_User_LoginUnique
     */
    private $_validator;
    
    protected function setUp()
    {
        parent::setUp();
        $this->_validator = new Validate_User_LoginUnique();
    }
    
    /**
     * @test
     * @dataProvider validValuesProvider
     */
    public function isValidWithValidValues($value, array $context)
    {
        $this->assertTrue($this->_validator->isValid($value, $context));
    }
    
    public static function validValuesProvider()
    {
        return array(
            array('non_existing_login', array()),
            array('', array()),
            array('admin', array(FieldIdEnum::USER_ID => '1'))
        );
    }
    
    /**
     * @test
     * @dataProvider invalidValuesProvider
     */
    public function isValidWithInvalidValues($value, array $context)
    {
        Fixture_Loader::create('User/2');
        $this->assertFalse($this->_validator->isValid($value, $context));
    }
    
    public function invalidValuesProvider()
    {
        return array(
            array('admin', array()),
            array('user', array(FieldIdEnum::USER_ID => '1')),
        );
    }
}
