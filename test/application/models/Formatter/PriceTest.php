<?php
/**
 * @class Formatter_PriceTest
 */ 
class Formatter_PriceTest extends TestCase_NoDatabase
{
    
    /**
     * @test
     */
    public function formatWithCurrency()
    {
        $this->assertEquals("USD 123", Formatter_Price::formatWithCurrency("123", "USD"));
    }
}
