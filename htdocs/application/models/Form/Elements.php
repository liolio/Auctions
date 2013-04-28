<?php
/**
 * @class Form_Elements
 */
abstract class Form_Elements
{
    
    /**
     * 
     * @return Zend_Translate
     */
    protected function _getTranslator()
    {
        return Helper::getTranslator();
    }
}
