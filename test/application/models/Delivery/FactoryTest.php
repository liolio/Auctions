<?php
/**
 * @class Delivery_FactoryTest
 */
class Delivery_FactoryTest extends TestCase_Database
{
    
    /**
     * @test
     */
    public function create()
    {
        $this->_loadFixtures(array(
            'Category/1',
            'Currency/1',
            'Auction/1_category_1_start_2012-05-02',
            'DeliveryType/1'
        ));
        
        $data = array(FieldIdEnum::DELIVERY_PRICE  =>  '2.00');
        
        $delivery = Delivery_Factory::create(
            $data, 
            AuctionTable::getInstance()->find(1),
            DeliveryTypeTable::getInstance()->find(1)
        );
        
        $this->assertEquals($data[FieldIdEnum::DELIVERY_PRICE], $delivery->price);
        $this->assertEquals(1, $delivery->auction_id);
        $this->assertEquals(1, $delivery->delivery_type_id);
    }
}
