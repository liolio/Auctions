<?php
/**
 * @class Auctions_Form_Abstract
 */
abstract class Auctions_Form_Abstract extends Zend_Form
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
