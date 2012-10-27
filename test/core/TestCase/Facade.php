<?php
/**
 * @class TestCase_Facade
 */
class TestCase_Facade
{
 
    /**
     * @var Zend_Translate
     */
    private $_translator;
    
    /**
     * @var boolean
     */
    private $_loadProductionFixtures = false;
    
    /**
     * Param decides if fixtures should be loaded.
     * 
     * @param boolean $loadFixtures
     */
    public function setLoadFixtures($loadFixtures = true)
    {
        $this->_loadProductionFixtures = (bool) $loadFixtures;
    }
    
    /**
     * Reloads database. Method setLoadFixtures decides if fixtures will be loaded.
     */
    public function reloadDatabase()
    {
        Database_Reloader::getInstance()->clearDatabase();
        
        if ($this->_loadProductionFixtures)
            Database_Reloader::getInstance()->loadFixtures();
    }
    
    public function getTimeDiff($first, $second)
    {
        if (!is_string($first) && !$first instanceof Zend_Date)
            throw new InvalidArgumentException("First parameter must be string or Zend_Date object, " . get_class($first) . " given.");
        
        if (!is_string($second) && !$second instanceof Zend_Date)
            throw new InvalidArgumentException("Second parameter must be string or Zend_Date object, " . get_class($first) . " given.");

        $firstTime = new Zend_Date($first);
        $secondTime = new Zend_Date($second);
        
        return abs($firstTime->sub($secondTime)->get(Zend_Date::TIMESTAMP));
    }
}
