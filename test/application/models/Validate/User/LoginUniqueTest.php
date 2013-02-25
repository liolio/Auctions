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
    public function isValidWithValidValues($value)
    {
        $this->assertTrue($this->_validator->isValid($value));
    }
    
    public static function validValuesProvider()
    {
        return array(
            array('non_existing_login'),
            array('')
        );
    }
    
    /**
     * @test
     */
    public function isValidWithInvalidValues()
    {
        $this->assertFalse($this->_validator->isValid('admin'));
    }
}
