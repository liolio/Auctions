<?php
/**
 * @interface Form_Elements
 */
abstract class Form_Elements
{
    
    /**
     * return array of Zend Form Elements.
     */
    abstract public function getElements();
    
    /**
     * 
     * @return Zend_Translate
     */
    protected function _getTranslator()
    {
        return Helper::getTranslator();
    }
}
