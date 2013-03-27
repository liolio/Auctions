<?php
/**
 * @class Currency_Factory
 */
class Currency_Factory
{
    
    /**
     * Creates new Currency object
     * 
     * @param array $data Array of valid data.
     * @return Address
     */
    public static function create(array $data)
    {
        $currency = new Currency();
        
        $currency->name = $data[FieldIdEnum::CURRENCY_NAME];
        
        return $currency;
    }
}
