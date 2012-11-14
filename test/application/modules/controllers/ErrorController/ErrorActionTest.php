<?php
/**
 * @class Auctions_ErrorController_ErrorActionTest
 */
class ErrorController_ErrorActionTest extends TestCase_Controller
{
    
    protected function setUp()
    {
        $this->_disableLoggingInAdminUser();
        parent::setUp();
    }
    
    /**
     * @test
     * @dataProvider dataProvider
     */
    public function errorAction($logInUser, $identity)
    {
        if ($logInUser)
            $this->_logInAdminUser();
        
        $this->dispatch('/not_existing');
        $this->_assertDispatch('error', 'error');
        
        $body = $this->getResponse()->getBody();
        $this->assertContains("An error occurred", $body);
        $this->assertContains("Page not found", $body);
        
        $logs = LogTable::getInstance()->findAll();
        $this->assertEquals(1, count($logs));
        
        $log = $logs->getFirst();
        $this->_assertTime(Zend_Date::now(), $log->timestamp);
        $this->assertEquals("NOTICE", $log->priority_name);
        $this->assertEquals(Zend_Log::NOTICE, $log->priority);
        $this->assertEquals("Zend_Controller_Dispatcher_Exception: Invalid controller specified (not_existing)", $log->message);
        $this->assertEquals($identity, $log->identity);
        $this->assertEquals($this->_getTranslator()->translate('configuration-undefined'), $log->ip_address);
        $this->assertEmpty($log->url);
        $this->assertNotEmpty($log->stack_trace);
        $this->assertEmpty($log->post);
    }
    
    public function dataProvider()
    {
        $user = UserTable::getInstance()->findOneBy('login', 'admin');
        return array(
            array(
                false,
                $this->_getTranslator()->translate('configuration-undefined')
            ),
            array(
                true,
                $user->id
            ),
        );
    }
}
