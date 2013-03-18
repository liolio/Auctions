<?php
/**
 * @class Auctions_AddressController_DeleteActionTEst
 */
class Auctions_AddressController_DeleteActionTest extends TestCase_Controller
{
    
    /**
     * @test
     */
    public function deleteLastAddress()
    {
        $this->dispatch('/address/delete/1');
        $this->_assertDispatch('address', 'delete');
        
        $this->assertContains(Helper::getTranslator()->translate('validation_message-address_cannot_remove_last_address'), $this->getResponse()->getBody());
        
        $this->assertEquals(1, AddressTable::getInstance()->count());
    }
    
    /**
     * @test
     */
    public function delete()
    {
        Fixture_Loader::create("Address/2_user_1");
        
        $this->dispatch('/address/delete/1');
        $this->_assertDispatch('address', 'delete');
        
        $this->assertEquals(1, AddressTable::getInstance()->count());
    }
}
