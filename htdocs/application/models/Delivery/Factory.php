<?php
/**
 * @class Delivery_Factory
 */
class Delivery_Factory
{
    
    public static function create(array $data, Auction $auction, DeliveryType $deliveryType)
    {
        $delivery = new Delivery();
        
        $delivery->price = $data[FieldIdEnum::DELIVERY_PRICE];
        $delivery->Auction = $auction;
        $delivery->DeliveryType = $deliveryType;
        
        return $delivery;
    }
}
