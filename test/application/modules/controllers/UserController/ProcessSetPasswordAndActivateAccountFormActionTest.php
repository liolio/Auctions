<?php
/**
 * @class Auctions_UserController_ProcessSetPasswordAndActivateAccountFormActionTest
 */
class Auctions_UserController_ProcessSetPasswordAndActivateAccountFormActionTest extends TestCase_Controller
{
    
    protected function setUp()
    {
        $this->_disableLoggingInAdminUser();
        parent::setUp();
        Fixture_Loader::create('user/4_inactive_with_secret_code');
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
        
        $this->dispatch('user/process-set-password-and-activate-account-form');
        $this->_assertDispatch('user', 'process-set-password-and-activate-account-form');
        
        $this->_assertRedirection("");
        
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
        
        $this->dispatch('user/process-set-password-and-activate-account-form');
        $this->_assertDispatch('user', 'process-set-password-and-activate-account-form');
        
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
        $this->dispatch('user/process-set-password-and-activate-account-form');
        $this->_assertAclDeny();
        
        $user = UserTable::getInstance()->findOneBy('login', 'user_inactive_with_secret_code');
        $this->assertFalse(Zend_Auth::getInstance()->hasIdentity());
        $this->assertEquals(str_repeat('0', 40), $user->password);
        $this->assertNotEmpty($user->secret_code);
        $this->assertFalse($user->active);
    }
}
