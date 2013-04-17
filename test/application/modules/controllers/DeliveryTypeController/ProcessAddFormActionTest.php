<?php
/**
 * @class Auctions_DeliveryTypeController_ProcessAddFormActionTest
 */
class Auctions_DeliveryTypeController_ProcessAddFormActionTest extends TestCase_Controller
{
    
    /**
     * @test
     */
    public function process()
    {
        $request = array(
            FieldIdEnum::DELIVERY_TYPE_NAME             =>  'name',
            FieldIdEnum::DELIVERY_TYPE_CASH_ON_DELIVERY =>  '1',
        );
        
        $this->_setRequest($request);
        
        $this->dispatch("delivery-type/process-add-form");
        $this->_assertDispatch('delivery-type', 'process-add-form');
        
        $this->_assertRedirection("delivery-type/show-administrator-list");
        
        $deliveryTypes = DeliveryTypeTable::getInstance()->findAll();
        $this->assertEquals(1, count($deliveryTypes));
        
        $deliveryType = $deliveryTypes->get(0);
        $this->assertEquals($request[FieldIdEnum::DELIVERY_TYPE_NAME], $deliveryType->name);
        $this->assertTrue($deliveryType->cash_on_delivery);
    }
    
    /**
     * @test
     */
    public function processWithInvalidData()
    {
        $this->_setRequest(array());
        
        $this->dispatch("delivery-type/process-add-form");
        $this->_assertDispatch('delivery-type', 'process-add-form');
        $this->assertContains(Helper::getTranslator()->translate("validation_message-field_empty"), $this->getResponse()->getBody());
        
        $this->assertEquals(0, DeliveryTypeTable::getInstance()->count());
    }
}
