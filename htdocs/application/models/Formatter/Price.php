<?php
/**
 * @class Formatter_Price
 */
class Formatter_Price
{
    
    /**
     * Returns price in format "CURRENCY PRICE"
     * 
     * @param String $price
     * @param String $currency
     * @return String
     */
    public static function formatWithCurrency($price, $currency)
    {
        return $currency . " " . $price;
    }
}
