<?php
/**
 * @class Auctions_AddressController_ShowListActionTest
 */
class Auctions_AddressController_ShowListActionTest extends TestCase_Controller
{
    
    /**
     * @test
     */
    public function showList()
    {
        $this->dispatch('/address/show-list');
        
        $response = $this->getResponse()->getBody();
        $this->assertContains("Ulica 2", $response);
        $this->assertContains("Polska", $response);
        $this->assertContains("654987321", $response);
    }
    
}
