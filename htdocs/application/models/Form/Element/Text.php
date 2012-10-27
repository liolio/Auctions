<?php
/**
 * @class Form_Element_Text
 */
class Form_Element_Text extends Zend_Form_Element_Text
{
    
    public function __construct($spec, $options = null)
    {
        parent::__construct($spec, $options);
        parent::addFilter(new Zend_Filter_StringTrim());
        parent::addFilter(new Zend_Filter_StripTags());
    }
}
