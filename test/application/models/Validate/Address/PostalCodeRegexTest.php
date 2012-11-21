<?php
/**
 * @class Validate_Address_PostalCodeRegexTest
 */
class Validate_Address_PostalCodeRegexTest extends TestCase_NoDatabase
{

    /**
     * @var Validate_Address_SurnameRegex
     */
    private $_validator;
    
    protected function setUp()
    {
        $this->_validator = new Validate_Address_PostalCodeRegex();
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
            array('30-072'),
            array('FL 12345'),
            array('123456'),
            array('FL-1234')
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
            array('35_100'),
            array('/*-')
        );
    }
}
