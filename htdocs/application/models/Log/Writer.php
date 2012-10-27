<?php
/**
 * @class Log_Writer
 */
class Log_Writer extends Zend_Log_Writer_Db
{
    
    const EXCEPTION = 'exception';
    
    private $_undefinedCaption;
    
    /**
     * Create a new instance of Zend_Log_Writer_Db
     * NOTICE:  Its overwritten because of using keyword 'self' instead of 'static'
     *          in parent class.
     *          And if any config array is used to create Zend_Log instance, it's
     *          executed factory method of each writer.
     *
     * @param  array|Zend_Config $config
     * @return Log_Writer_Db
     * @throws Zend_Log_Exception
     */
    static public function factory($config)
    {
        return new self();
    }

    public function __construct()
    {
        $connection = Doctrine_Manager::getInstance()
                ->getConnection(Zend_Registry::get('config')->doctrine->database_name);

        $columnMapping = array(
            'timestamp'         => 'timestamp',
            'priority_name'     => 'priorityName',
            'priority'          => 'priority',
            'message'           => 'message',
            'identity'          => 'identity',
            'ip_address'        => 'ip_address',
            'url'               => 'url',
            'stack_trace'       => 'stack_trace',
            'post'              => 'post',
        );

        parent::__construct($connection, LogTable::getInstance() ,$columnMapping);
    }

    protected function _write($event)
    {
        $url = array_key_exists('REQUEST_URI', $_SERVER) ? $_SERVER['REQUEST_URI'] : '';
        $identity = Zend_Auth::getInstance()->hasIdentity() ? Zend_Auth::getInstance()->getIdentity() : $this->_getUndefinedCaption();
        $ipAddress = array_key_exists('REMOTE_ADDR', $_SERVER) ? $_SERVER['REMOTE_ADDR'] : $this->_getUndefinedCaption();

        $event = array_merge(
            $event,
            array(
                'identity'      =>  $identity,
                'ip_address'    =>  $ipAddress,
                'post'          =>  http_build_query($_POST),
                'url'           =>  $url,
                'stack_trace'   =>  ''
            )
        );
        
        if (array_key_exists('exception', $event))
        {
            $event['stack_trace'] = $event['exception']->getTraceAsString();
            $event['message'] = get_class($event['exception']) . ': ' . $event['exception']->getMessage();
        }

        parent::_write($event);
    }
    
    private function _getUndefinedCaption()
    {
        if (is_null($this->_undefinedCaption))
            $this->_undefinedCaption = Zend_Registry::get('Zend_Translate')->translate('configuration-undefined');
        
        return $this->_undefinedCaption;
    }
}