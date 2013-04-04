<?php
/**
 * @class CurrencyTableTest
 */
class CurrencyTableTest extends TestCase_Database
{
    
    /**
     * @test
     * @dataProvider dataProvider
     */
    public function isCurrencyUnique($name, $id, $expectedResult)
    {
        $this->_loadFixture("Currency/1");
        $this->assertEquals($expectedResult, CurrencyTable::getInstance()->isCurrencyUnique($name, $id));
    }
    
    public function dataProvider()
    {
        return array(
            array("EUR", null, true),
            array("EUR", '1', true),
            array("", null, true),
            array("PLN", '1', true),
            
            array("PLN", null, false),
        );
    }
}
