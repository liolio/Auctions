<?php
/**
 * @class Auctions_UserController_SetPasswordAndRegisterAccountActionTest
 */
class Auctions_UserController_SetPasswordAndRegisterAccountActionTest extends TestCase_Controller
{
    
    protected function setUp()
    {
        $this->_disableLoggingInAdminUser();
        parent::setUp();
        Fixture_Loader::create('User/4_inactive_with_secret_code');
    }
    
    /**
     * @test
     */
    public function set()
    {
        $this->_setRequest(array(
            FieldIdEnum::USER_SECRET_CODE   =>  'sercret1234'
        ));
        
        $this->dispatch('user/set-password-and-register-account');
        $this->_assertDispatch('user', 'set-password-and-register-account');
        
        $response = $this->getResponse()->getBody();
        $this->assertContains('user_inactive_with_secret_code', $response);
    }
    
    /**
     * @test
     */
    public function setWithInvalidSecretCode()
    {
        $this->_setRequest(array(
            FieldIdEnum::USER_SECRET_CODE   =>  'invalid!@#$%^&*()_+'
        ));
        
        $this->dispatch('user/set-password-and-register-account');
        $this->_assertAclDeny();
    }
    
    /**
     * @test
     */
    public function setWithoutSecretCode()
    {
        $this->dispatch('user/set-password-and-register-account');
        $this->_assertAclDeny();
    }
}
