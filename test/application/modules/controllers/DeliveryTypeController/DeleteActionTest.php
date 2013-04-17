<?php
/**
 * @class Auctions_DeliveryTypeController_DeleteActionTest
 */
class Auctions_DeliveryTypeController_DeleteActionTest extends TestCase_Controller
{
    
    /**
     * @test
     */
    public function deleteLastAddress()
    {
        $this->_loadFixture("Currency/1");
        $this->_loadFixture("Category/1");
        $this->_loadFixture("Auction/1_category_1_start_2012-05-02");
        $this->_loadFixture("DeliveryType/1");
        $this->_loadFixture("Delivery/1_delivery_type_1_auction_1");
        
        $this->dispatch('/delivery-type/delete/1');
        $this->_assertDispatch('delivery-type', 'delete');
        
        $this->assertContains(
            Helper::getTranslator()->translate('validation_message-cannot_delete_delivery_type_has_deliveries'),
            $this->getResponse()->getBody()
        );
        
        $this->assertEquals(1, DeliveryTypeTable::getInstance()->count());
    }
    
    /**
     * @test
     */
    public function delete()
    {
        $this->_loadFixture("DeliveryType/1");
        
        $this->dispatch('/delivery-type/delete/1');
        $this->_assertDispatch('delivery-type', 'delete');
        
        $this->_assertRedirection("delivery-type/show-administrator-list");
        
        $this->assertEquals(0, DeliveryTypeTable::getInstance()->count());
    }
}
