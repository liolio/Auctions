<?php
/**
 * @class Form_Element_Textarea
 */
class Form_Element_Textarea extends Zend_Form_Element_Textarea
{
   
    const COLS = 'COLS';
    const ROWS = 'ROWS';
    
    public function __construct($spec, $options = null)
    {
        parent::__construct($spec, $options);
        parent::addFilter(new Zend_Filter_StringTrim());
        parent::addFilter(new Zend_Filter_StripTags());
        parent::setAttrib(self::COLS, '40');
        parent::setAttrib(self::ROWS, '4');
    }
    
    //@override
    public function setRequired($flag = true)
    {
        parent::setRequired($flag);
        
        if ($flag)
            parent::addValidator(new Validate_NotEmpty(), true);
        else
            parent::removeValidator('Validate_NotEmpty');
        
        return $this;
    }
}
