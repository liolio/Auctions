<?php
/**
 * @class Form_Element_Select
 */
class Form_Element_Select extends Zend_Form_Element_Select
{
    
    public function __construct($spec, $options = null)
    {
        parent::__construct($spec, $options);
        $this->setAttrib('class', 'formSelect');
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
