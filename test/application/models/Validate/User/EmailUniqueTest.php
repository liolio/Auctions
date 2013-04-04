<?php
/**
 * @class Validate_User_EmailUniqueTest
 */
class Validate_User_EmailUniqueTest extends TestCase_Database
{
    
    /**
     * @var Validate_User_EmailUnique
     */
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
    public function isValidWithValidValues($value, array $context)
    {
        $this->assertTrue($this->_validator->isValid($value, $context));
    }
    
    public static function validValuesProvider()
    {
        return array(
            array('non_existing@email.com', array()),
            array('lio_lio@wp.pl', array(FieldIdEnum::USER_ID => '1')),
            array('', array())
        );
    }
    
    /**
     * @test
     * @dataProvider invalidValuesProvider
     */
    public function isValidWithInvalidValues($value, array $context)
    {
        $this->_loadFixture('User/2');
        $this->assertFalse($this->_validator->isValid($value, $context));
    }
    
    public function invalidValuesProvider()
    {
        return array(
            array('lio_lio@wp.pl', array()),
            array('user@email.com', array(FieldIdEnum::USER_ID => '1')),
        );
    }
}
