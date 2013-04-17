<?php
/**
 * @class DeliveryType_Factory
 */
class DeliveryType_Factory
{
    
    /**
     * Creates new DeliveryType object
     * 
     * @param array $data Array of valid data.
     * @return DeliveryType
     */
    public static function create(array $data)
    {
        $deliveryType = new DeliveryType();
        
        $deliveryType->name = $data[FieldIdEnum::DELIVERY_TYPE_NAME];
        $deliveryType->cash_on_delivery = $data[FieldIdEnum::DELIVERY_TYPE_CASH_ON_DELIVERY];
        
        return $deliveryType;
    }
}
