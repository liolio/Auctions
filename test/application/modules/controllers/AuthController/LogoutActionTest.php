<?php
/**
 * @class Auctions_AuthController_LogoutActionTest
 */
class Auctions_AuthController_LogoutActionTest extends TestCase_Controller
{
    
    /**
     * @test
     */
    public function logoutTest()
    {
        $this->dispatch('/logout');
        $this->_assertDispatch('auth', 'logout');
        
        $this->assertFalse(Zend_Auth::getInstance()->hasIdentity());
    }
}
