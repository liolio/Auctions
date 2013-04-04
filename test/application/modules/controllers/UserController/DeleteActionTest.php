<?php
/**
 * @class Auctions_UserController_DeleteActionTest
 */
class Auctions_UserController_DeleteActionTest extends TestCase_Controller
{
    
    /**
     * @test
     */
    public function deleteOwnAccount()
    {
        $this->dispatch('/user/delete/1');
        $this->_assertDispatch('user', 'delete');
        
        $this->assertContains(
            Helper::getTranslator()->translate('validation_message-cannot_delete_your_own_account'),
            $this->getResponse()->getBody()
        );
        
        $this->assertEquals(1, UserTable::getInstance()->count());
    }
    
    /**
     * @test
     */
    public function delete()
    {
        $this->_loadFixture("User/2");
        
        $this->dispatch('/user/delete/2');
        $this->_assertDispatch('user', 'delete');
        
        $this->_assertRedirection("user/show-list");
        
        $this->assertEquals(1, UserTable::getInstance()->count());
    }
}
