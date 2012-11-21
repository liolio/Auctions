<?php
/**
 * @class Validate_Address_PhoneNumberRegexTest
 */
class Validate_Address_PhoneNumberRegexTest extends TestCase_NoDatabase
{

    /**
     * @var Validate_Address_PhoneNumberRegex
     */
    private $_validator;
    
    protected function setUp()
    {
        $this->_validator = new Validate_Address_PhoneNumberRegex();
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
            array('+48 12 32145687951'),
            array('0700123456'),
            array('0 700 12 34 56'),
            array('+48 12-213-456')
        );
    }

    /**
     * @test
     * @dataProvider invalidValuesProvider
     */
    public function isValidWithInvalidValues($value)
    {
        $this->assertFalse($this->_validator->isValid($value));
        
        $this->assertEquals(
                array(Validate_Address_StreetRegex::NOT_MATCH),
                $this->_validator->getErrors()
        );
    }
    
    public static function invalidValuesProvider()
    {
        return array(
            array('00_00'),
            array('123JEDEN')
        );
    }
}
