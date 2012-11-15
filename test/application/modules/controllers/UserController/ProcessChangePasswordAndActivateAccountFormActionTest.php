<?php
/**
 * @class Auctions_UserController_ProcessChangePasswordAndActivateAccountFormActionTest
 */
class Auctions_UserController_ProcessChangePasswordAndActivateAccountFormActionTest extends TestCase_Controller
{
    
    protected function setUp()
    {
        $this->_disableLoggingInAdminUser();
        parent::setUp();
        Fixture_Factory::create('user/4_inactive_with_secret_code');
    }
    
    /**
     * @test
     */
    public function process()
    {
        $this->_setRequest(array(
            FieldIdEnum::USER_LOGIN         =>  'user_inactive_with_secret_code',
            FieldIdEnum::USER_PASSWORD      =>  'qwe',
            ParamIdEnum::PASSWORD_REPEAT    =>  'qwe'
        ));
        
        $this->dispatch('user/process-change-password-and-activate-account-form');
        $this->_assertDispatch('user', 'process-change-password-and-activate-account-form');
        $headers = $this->getResponse()->getHeaders();
        $this->assertEquals(Zend_Controller_Front::getInstance()->getBaseUrl() . '/', $headers[0]['value']);
        
        $user = UserTable::getInstance()->findOneBy('login', 'user_inactive_with_secret_code');
        $this->assertTrue(Zend_Auth::getInstance()->hasIdentity());
        $this->assertEquals($user->id, Zend_Auth::getInstance()->getIdentity());
        $this->assertNotEquals(str_repeat('0', 40), $user->password);
        $this->assertEmpty($user->secret_code);
        $this->assertTrue($user->active);
    }
    
    /**
     * @test
     */
    public function processWithNotMatchingPasswords()
    {
        $this->_setRequest(array(
            FieldIdEnum::USER_LOGIN         =>  'user_inactive_with_secret_code',
            FieldIdEnum::USER_PASSWORD      =>  'qwe',
            ParamIdEnum::PASSWORD_REPEAT    =>  'qwe_not_matching'
        ));
        
        $this->dispatch('user/process-change-password-and-activate-account-form');
        $this->_assertDispatch('user', 'process-change-password-and-activate-account-form');
        
        $this->assertContains($this->_getTranslator()->translate('validation_message-user_passwords_not_match'), $this->getResponse()->getBody());
                
        $user = UserTable::getInstance()->findOneBy('login', 'user_inactive_with_secret_code');
        $this->assertFalse(Zend_Auth::getInstance()->hasIdentity());
        $this->assertEquals(str_repeat('0', 40), $user->password);
        $this->assertNotEmpty($user->secret_code);
        $this->assertFalse($user->active);
    }
    
    /**
     * @test
     */
    public function processWithoutData()
    {
        $this->dispatch('user/process-change-password-and-activate-account-form');
        $this->_assertDispatch('user', 'process-change-password-and-activate-account-form');
        
        $headers = $this->getResponse()->getHeaders();
        $this->assertEquals(Zend_Controller_Front::getInstance()->getBaseUrl() . '/user/registration', $headers[0]['value']);
                
        $user = UserTable::getInstance()->findOneBy('login', 'user_inactive_with_secret_code');
        $this->assertFalse(Zend_Auth::getInstance()->hasIdentity());
        $this->assertEquals(str_repeat('0', 40), $user->password);
        $this->assertNotEmpty($user->secret_code);
        $this->assertFalse($user->active);
    }
}