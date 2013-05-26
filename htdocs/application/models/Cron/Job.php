<?php
/**
 * @class Cron_Job
 */
abstract class Cron_Job
{
    public function run()
    {
        try
        {
            Doctrine_Manager::connection()->beginTransaction();
            $this->_execute();
            Doctrine_Manager::connection()->commit();
        }
        catch (Exception $ex)
        {
            Doctrine_Manager::connection()->rollback();
            Log_Factory::create($ex, Zend_Log::CRIT);
        }
    }
    
    abstract protected function _execute();
    
    /**
     * 
     * @return Zend_Date
     */
    protected function _getNow()
    {
        return Zend_Date::now();
    }
}

