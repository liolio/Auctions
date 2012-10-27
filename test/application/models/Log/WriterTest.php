<?php
/**
 * @class Log_WriterTest
 */
class Log_WriterTest extends TestCase_Controller
{
    
    /**
     * @var Log_Writer
     */
    private $_logWriter;
    
    /**
     * @var Zend_Date
     */
    private $_date;
    
    protected function setUp()
    {
        $this->_disableLoggingInAdminUser();
        
        parent::setUp();
        
        $this->_logWriter = new Log_Writer();
        $this->_date = Zend_Date::now()->get('YYYY-MM-dd HH:mm:ss');
    }
    
    /**
     * @test
     */
    public function logWithoutExceptionWithUndefinedUserAndIpAddress()
    {
        $this->_logWriter->write($this->_getEvent());
        
        $logs = LogTable::getInstance()->findAll();
        $this->assertEquals(1, count($logs));
        
        $log = $logs->getFirst();
        $undefinedCaption = $this->_getTranslator()->translate('configuration-undefined');
        
        $this->_assertTime(Zend_Date::now(), $log->timestamp);
        $this->assertEquals("WARN", $log->priority_name);
        $this->assertEquals(Zend_Log::WARN, $log->priority);
        $this->assertEquals("message", $log->message);
        $this->assertEquals($undefinedCaption, $log->identity);
        $this->assertEquals($undefinedCaption, $log->ip_address);
        $this->assertEmpty($log->url);
        $this->assertEmpty($log->stack_trace);
        $this->assertEmpty($log->post);
    }
    
    /**
     * @test
     */
    public function logWithoutExceptionWithUndefinedIpAddress()
    {
        $this->_logInAdminUser();
        $this->_logWriter->write($this->_getEvent());
        
        $logs = LogTable::getInstance()->findAll();
        $this->assertEquals(1, count($logs));
        
        $log = $logs->getFirst();
        $this->_assertTime(Zend_Date::now(), $log->timestamp);
        $this->assertEquals("WARN", $log->priority_name);
        $this->assertEquals(Zend_Log::WARN, $log->priority);
        $this->assertEquals("message", $log->message);
        $this->assertEquals($this->_getLoggedUser()->id, $log->identity);
        $this->assertEquals($this->_getTranslator()->translate('configuration-undefined'), $log->ip_address);
        $this->assertEmpty($log->url);
        $this->assertEmpty($log->stack_trace);
        $this->assertEmpty($log->post);
    }
    
    /**
     * @test
     */
    public function logWithoutException()
    {
        $this->_logInAdminUser();
        $oldRemoteAddr = array_key_exists('REMOTE_ADDR', $_SERVER) ? $_SERVER['REMOTE_ADDR'] : null;
        
        try
        {
            $_SERVER['REMOTE_ADDR'] = '10.11.12.13';
            $this->_logWriter->write($this->_getEvent());

            $logs = LogTable::getInstance()->findAll();
            $this->assertEquals(1, count($logs));

            $log = $logs->getFirst();
            $this->_assertTime(Zend_Date::now(), $log->timestamp);
            $this->assertEquals("WARN", $log->priority_name);
            $this->assertEquals(Zend_Log::WARN, $log->priority);
            $this->assertEquals("message", $log->message);
            $this->assertEquals($this->_getLoggedUser()->id, $log->identity);
            $this->assertEquals($_SERVER['REMOTE_ADDR'], $log->ip_address);
            $this->assertEmpty($log->url);
            $this->assertEmpty($log->stack_trace);
            $this->assertEmpty($log->post);
            $this->_revertRemoteAddr($oldRemoteAddr);
        }
        catch (Exception $exception)
        {
            $this->_revertRemoteAddr($oldRemoteAddr);
            throw $exception;
        }
    }
    
    /**
     * @test
     */
    public function logWithException()
    {
        $this->_logInAdminUser();
        $exception = new Exception('Exception message');
        
        $this->_logWriter->write($this->_getEvent($exception));
        
        $logs = LogTable::getInstance()->findAll();
        $this->assertEquals(1, count($logs));
        
        $log = $logs->getFirst();
        $this->_assertTime(Zend_Date::now(), $log->timestamp);
        $this->assertEquals("WARN", $log->priority_name);
        $this->assertEquals(Zend_Log::WARN, $log->priority);
        $this->assertEquals("Exception: Exception message", $log->message);
        $this->assertEquals($this->_getLoggedUser()->id, $log->identity);
        $this->assertEquals($this->_getTranslator()->translate('configuration-undefined'), $log->ip_address);
        $this->assertEmpty($log->url);
        $this->assertEquals($exception->getTraceAsString(), $log->stack_trace);
        $this->assertEmpty($log->post);
    }
    
    /**
     * @test
     */
    public function logWithExceptionAndPost()
    {
        $this->_logInAdminUser();
        $exception = new Exception('Exception message');
        $_POST = array(
            'PARAM1'    =>  'value1',
            'PARAM2'    =>  'value2',
            'PARAM3'    =>  'value3'
        );
        
        $this->_logWriter->write($this->_getEvent($exception));
        
        $logs = LogTable::getInstance()->findAll();
        $this->assertEquals(1, count($logs));
        
        $log = $logs->getFirst();
        $logPost = array();
        parse_str($log->post, $logPost);
        
        $this->_assertTime(Zend_Date::now(), $log->timestamp);
        $this->assertEquals("WARN", $log->priority_name);
        $this->assertEquals(Zend_Log::WARN, $log->priority);
        $this->assertEquals("Exception: Exception message", $log->message);
        $this->assertEquals($this->_getLoggedUser()->id, $log->identity);
        $this->assertEquals($this->_getTranslator()->translate('configuration-undefined'), $log->ip_address);
        $this->assertEmpty($log->url);
        $this->assertEquals($exception->getTraceAsString(), $log->stack_trace);
        $this->assertEquals($_POST, $logPost);
    }
    
    private function _revertRemoteAddr($oldRemoteAddr)
    {
        if (is_null($oldRemoteAddr))
            unset($_SERVER['REMOTE_ADDR']);
        else
            $_SERVER['REMOTE_ADDR'] = $oldRemoteAddr;
    }
    
    /**
     * 
     * @param Exception $exception [optional] Default set to null
     * @return array
     */
    private function _getEvent(Exception $exception = null)
    {
        $event = array(
            'timestamp'     =>  Zend_Date::now()->get('YYYY-MM-dd HH:mm:ss'),
            'priorityName'  =>  'WARN',
            'priority'      =>  Zend_Log::WARN,
            'message'       =>  'message'
        );
        
        if (!is_null($exception))
            $event['exception'] = $exception;
        
        return $event;
    }
}
