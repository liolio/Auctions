<?php
/**
 * @class ProcessActionTest
 */
class ProcessActionTest extends TestCase_Controller
{
    
    private $_auth;
    
    /**
     * Set up MVC app
     *
     * Calls {@link bootstrap()} by default
     *
     * @return void
     */
    protected function setUp()
    {
        $this->_disableLoggingInAdminUser();
        
        parent::setUp();
        
        $this->_auth = Zend_Auth::getInstance();
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
        
        $this->assertEmpty($this->_response->getBody());
        
        $headers = $this->_response->getHeaders();
        $this->assertEquals(1, count($headers));
        $this->assertEquals(
                array(
                    "name"      =>  "Location",
                    "value"     =>  $this->getFrontController()->getBaseUrl() . '/',
                    "replace"   =>  true
                ),
                $headers[0]
        );
    }
}
