<?php
/**
 * @class Validate_Address_SurnameRegexTest
 */
class Validate_Address_SurnameRegexTest extends TestCase_NoDatabase
{

    /**
     * @var Validate_Address_SurnameRegex
     */
    private $_validator;
    
    protected function setUp()
    {
        $this->_validator = new Validate_Address_SurnameRegex();
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
            array('Kowalska-Nowak'),
            array('Żółw'),
            array('Małpa Krowa')
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
            array('Kowlaska 2'),
            array(' ')
        );
    }
}
