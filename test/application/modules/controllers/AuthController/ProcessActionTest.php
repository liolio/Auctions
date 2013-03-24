<?php
/**
 * @class Auctions_AuthController_ProcessActionTest
 */
class Auctions_AuthController_ProcessActionTest extends TestCase_Controller
{
    
    /**
     *
     * @var Zend_Auth
     */
    private $_auth;
    
    /**
     *
     * @var User
     */
    private $_user;
    
    protected function setUp()
    {
        $this->_disableLoggingInAdminUser();
        
        parent::setUp();
        
        $this->_auth = Zend_Auth::getInstance();
        $this->_user = UserTable::getInstance()->findOneBy('login', 'admin');
    }
    
    /**
     * @test
     */
    public function processActionWithInvalidCredentials()
    {
        $this->assertFalse($this->_auth->hasIdentity());
        $this->_setRequest(array(
            FieldIdEnum::USER_LOGIN     => 'admin',
            FieldIdEnum::USER_PASSWORD  => 'admin2'
        ));
        
        $this->dispatch('/login/process');
        $this->_assertDispatch('auth', 'process');
        
        $this->assertContains($this->_getTranslator()->translate('validation_message-invalid_credentials'), $this->_response->getBody());
        $this->assertFalse($this->_auth->hasIdentity());
        
        $this->assertEmpty($this->_user->last_login);
    }
    
    /**
     * @test
     */
    public function processActionWithValidCredentials()
    {
        $this->assertFalse($this->_auth->hasIdentity());
        $this->_setRequest(array(
            FieldIdEnum::USER_LOGIN     => 'admin',
            FieldIdEnum::USER_PASSWORD  => 'admin'
        ));
        
        $this->dispatch('/login/process');
        $this->_assertDispatch('auth', 'process');
        
        $auth = Zend_Auth::getInstance();
        $this->assertTrue($auth->hasIdentity());
        $this->assertEquals(
                UserTable::getInstance()->findOneBy('login', 'admin')->id,
                $auth->getIdentity()
        );
        
        $this->_assertTime(Zend_Date::now(), $this->_user->last_login);
        
        $this->assertEmpty($this->_response->getBody());
        
        $this->_assertRedirection("");
    }
}
