<?php
/**
 * @class Log_Factory
 */
class Log_Factory
{
    
    /**
     * Creates new Log
     * 
     * @param Exception $exception
     * @param Zend_Log $priority            one of Zend_Log consts
     */
    public static function create(Exception $exception, $priority)
    {
        self::_create(
            get_class($exception) . ': ' . $exception->getMessage(),
            $priority,
            self::_getExtras($exception)
        );
    }
    
    private static function _create($message, $priority, array $extras)
    {
        Zend_Registry::get('logFactory')->log($message, $priority, $extras);
    }
    
    private static function _getExtras(Exception $exception = null)
    {
        if (is_null($exception))
            return array();
        
        $extras = array(
            Log_Writer::EXCEPTION   =>  $exception
        );
        
        return $extras;
    }
}
