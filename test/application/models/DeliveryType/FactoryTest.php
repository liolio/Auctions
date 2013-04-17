<?php
/**
 * @class DeliveryType_FactoryTest
 */
class DeliveryType_FactoryTest extends TestCase_NoDatabase
{
    
    /**
     * @test
     */
    public function create()
    {
        $data = array(
            FieldIdEnum::DELIVERY_TYPE_NAME             =>  'name',
            FieldIdEnum::DELIVERY_TYPE_CASH_ON_DELIVERY =>  '0',
        );
        
        $deliveryType = DeliveryType_Factory::create($data);
        
        $this->assertEquals($data[FieldIdEnum::DELIVERY_TYPE_NAME], $deliveryType->name);
        $this->assertEquals($data[FieldIdEnum::DELIVERY_TYPE_CASH_ON_DELIVERY], $deliveryType->cash_on_delivery);
    }
}
