<?php
/**
 * @class Validate_User_EmailExistsTest
 */
class Validate_User_EmailExistsTest extends TestCase_Database
{
    
    private $_validator;
    
    protected function setUp()
    {
        parent::setUp();
        $this->_validator = new Validate_User_EmailExists();
    }
    
    /**
     * @test
     */
    public function isValidWithValidValues()
    {
        $this->assertTrue($this->_validator->isValid('lio_lio@wp.pl'));
    }
    
    /**
     * @test
     * @dataProvider invalidValuesProvider
     */
    public function isValidWithInvalidValues($value)
    {
        $this->assertFalse($this->_validator->isValid($value));
    }
    
    public static function invalidValuesProvider()
    {
        return array(
            array('non_existing@email.com'),
            array('')
        );
    }
}
