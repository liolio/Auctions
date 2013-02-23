<?php
/**
 * @class Form_Element_Password
 */
class Form_Element_Password extends Zend_Form_Element_Password
{
    
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