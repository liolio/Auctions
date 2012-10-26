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
    
    /**
     * Returns default translator.
     * 
     * @return Zend_Translate
     */
    public function getTranslator()
    {
        if (is_null($this->_translator))
            $this->_translator = Zend_Registry::get('Zend_Translate');
        
        return $this->_translator;
    }
}
