<?php
/**
 * @class Validate_Currency_NameUniqueTest
 */
class Validate_Currency_NameUniqueTest extends TestCase_Database
{
    
    /**
     * @var Validate_Currency_NameUnique
     */
    private $_validator;
    
    protected function setUp()
    {
        parent::setUp();
        $this->_validator = new Validate_Currency_NameUnique();
    }
    
    /**
     * @test
     * @dataProvider dataProvider
     */
    public function isValid($value, array $context, $expectedResult)
    {
        $this->_loadFixture("Currency/1");
        $this->assertEquals($expectedResult, $this->_validator->isValid($value, $context));
    }
    
    public function dataProvider()
    {
        return array(
            array("EUR", array(), true),
            array("", array(), true),
            array("PLN", array(FieldIdEnum::CURRENCY_ID => '1'), true),
            
            array("PLN", array(), false),
        );
    }
}
