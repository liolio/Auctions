<?php
/**
 * @class Validate_User_EmailUniqueTest
 */
class Validate_User_EmailUniqueTest extends TestCase_Database
{
    
    private $_validator;
    
    protected function setUp()
    {
        parent::setUp();
        $this->_validator = new Validate_User_EmailUnique();
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
            array('non_existing@email.com'),
            array('')
        );
    }
    
    /**
     * @test
     */
    public function isValidWithInvalidValues()
    {
        $this->assertFalse($this->_validator->isValid('lio_lio@wp.pl'));
    }
}
