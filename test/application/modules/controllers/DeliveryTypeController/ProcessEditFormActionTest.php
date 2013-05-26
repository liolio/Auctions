<?php
/**
 * @class Auctions_DeliveryTypeController_ProcessEditFormActionTest
 */
class Auctions_DeliveryTypeController_ProcessEditFormActionTest extends TestCase_Controller
{
    
    /**
     * @test
     */
    public function process()
    {
        $this->_loadFixture("DeliveryType/1");
        $request = array(
            FieldIdEnum::DELIVERY_TYPE_ID               =>  '1',
            FieldIdEnum::DELIVERY_TYPE_NAME             =>  'new name',
            FieldIdEnum::DELIVERY_TYPE_CASH_ON_DELIVERY =>  '0',
        );
        
        $this->_setRequest($request);
        
        $this->dispatch("delivery-type/process-edit-form");
        $this->_assertDispatch('delivery-type', 'process-edit-form');
        
        $this->_assertRedirection("delivery-type/show-administrator-list");
        
        $deliveryTypes = DeliveryTypeTable::getInstance()->findAll();
        $this->assertEquals(1, count($deliveryTypes));
        
        $delivery = $deliveryTypes->get(0);
        $this->assertEquals($request[FieldIdEnum::DELIVERY_TYPE_NAME], $delivery->name);
        $this->assertFalse($delivery->cash_on_delivery);
    }
    
    /**
     * @test
     */
    public function processWithInvalidData()
    {
        $this->_setRequest(array());
        
        $this->dispatch("delivery-type/process-edit-form");
        $this->_assertDispatch('delivery-type', 'process-edit-form');
        $this->assertContains($this->_getTranslator()->translate("validation_message-field_empty"), $this->getResponse()->getBody());
        
        $this->assertEquals(0, DeliveryTypeTable::getInstance()->count());
    }
}
