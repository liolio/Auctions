<?php
/**
 * @class Form_Element_Radio
 */
class Form_Element_Radio extends Zend_Form_Element_Radio
{
    
    public function __construct($spec, $options = null)
    {
        parent::__construct($spec, $options);
        
        $this->setAttrib('class', 'formRadio');
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
