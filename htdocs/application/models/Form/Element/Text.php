<?php
/**
 * @class Form_Element_Text
 */
class Form_Element_Text extends Zend_Form_Element_Text
{
    /**
     * Constructor
     * @overrides
     *
     * $spec may be:
     * - string: name of element
     * - array: options with which to configure element
     * - Zend_Config: Zend_Config with options for configuring element
     *
     * @param  string|array|Zend_Config $spec
     * @param  array|Zend_Config $options
     * @return void
     * @throws Zend_Form_Exception if no element name after initialization
     */
    public function __construct($spec, $options = null)
    {
        parent::__construct($spec, $options);
        parent::addFilter(new Zend_Filter_StringTrim());
        parent::addFilter(new Zend_Filter_StripTags());
    }
}
