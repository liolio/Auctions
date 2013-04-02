<?php
/**
 * @class TestCase_NoDatabase
 */
abstract class TestCase_NoDatabase extends PHPUnit_Framework_TestCase
{
    
    protected $backupGlobals = false;
    
    /**
     * @var TestCase_Facade
     */
    private $_facade;
    
    protected function _assertTime($first, $second, $allowedTimeDiff = 2)
    {
        $timeDiff = $this->_getFacade()->getTimeDiff($first, $second);
        $this->assertTrue($timeDiff <= $allowedTimeDiff);
    }
    
    /**
     * 
     * @return Zend_Translate
     */
    protected function _getTranslator()
    {
        return Helper::getTranslator();
    }
    
    /**
     * 
     * @return TestCase_Facade
     */
    private function _getFacade()
    {
        if (is_null($this->_facade))
            $this->_facade = new TestCase_Facade();
        
        return $this->_facade;
    }
}
