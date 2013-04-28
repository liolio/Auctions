<?php
/**
 * @class Validate_Float
 */
class Validate_Float extends Zend_Validate_Float
{
    
    public function __construct($options = array())
    {
        $this->_messageTemplates[self::INVALID] = Helper::getTranslator()->translate('validation_message-float_invalid_type');
        $this->_messageTemplates[self::NOT_FLOAT] = Helper::getTranslator()->translate('validation_message-float_not_float');
        
        parent::__construct($options);
    }
    
    public function isValid($value)
    {
        return parent::isValid(str_replace(".", ",", $value));
    }
}
