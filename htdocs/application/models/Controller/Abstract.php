<?php
/**
 * @class Controller_Abstract
 */
abstract class Controller_Abstract extends Zend_Controller_Action
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
