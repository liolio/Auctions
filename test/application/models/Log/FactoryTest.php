<?php
/**
 * @class Log_FactoryTest
 */
class Log_FactoryTest extends TestCase_Controller
{
    
    /**
     * @test
     */
    public function create()
    {
        $exception = new Exception('Interesting message');
        Log_Factory::create($exception, Zend_Log::ALERT);
        
        $logs = LogTable::getInstance()->findAll();
        $this->assertEquals(1, count($logs));
        
        $log = $logs->getFirst();
        $undefinedCaption = $this->_getTranslator()->translate('configuration-undefined');
        
        $this->_assertTime(Zend_Date::now(), $log->timestamp);
        $this->assertEquals("ALERT", $log->priority_name);
        $this->assertEquals(Zend_Log::ALERT, $log->priority);
        $this->assertEquals("Exception: Interesting message", $log->message);
        $this->assertEquals($this->_getLoggedUser()->id, $log->identity);
        $this->assertEquals($undefinedCaption, $log->ip_address);
        $this->assertEmpty($log->url);
        $this->assertEquals($exception->getTraceAsString(), $log->stack_trace);
        $this->assertEmpty($log->post);
    }
}
