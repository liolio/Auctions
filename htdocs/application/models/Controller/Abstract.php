<?php
/**
 * @class Controller_Abstract
 */
abstract class Controller_Abstract extends Zend_Controller_Action
{
    
    /**
     * @var Zend_Translate
     */
    private $_translator;
    
    /**
     * 
     * @return Zend_Translate
     */
    protected function _getTranslator()
    {
        if (is_null($this->_translator))
            $this->_translator = Zend_Registry::get("Zend_Translate");
        
        return $this->_translator;
    }
}
