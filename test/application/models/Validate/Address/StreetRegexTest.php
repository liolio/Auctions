<?php
/**
 * @class Validate_Address_StreetRegexTest
 */
class Validate_Address_StreetRegexTest extends TestCase_NoDatabase
{

    /**
     * @var Validate_Address_StreetRegex
     */
    private $_validator;
    
    protected function setUp()
    {
        $this->_validator = new Validate_Address_StreetRegex();
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
            array('ul. Budryka 2/1'),
            array('123 Super Street'),
            array('ąśżźćęółĄŚŻŹĆÓŁĘ'),
            array('1 '),
            array('A ')
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
            array('ul. Budryka 2/1 *'),
            array(' '),
            array('123 Super_Street'),
        );
    }
}
