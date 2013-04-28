<?php
/**
 * @class Validate_Int
 */
class Validate_Int extends Zend_Validate_Int
{
    
    public function __construct($options = array())
    {
        $this->_messageTemplates[self::INVALID] = Helper::getTranslator()->translate('validation_message-int_invalid_type');
        $this->_messageTemplates[self::NOT_INT] = Helper::getTranslator()->translate('validation_message-int_not_int');
        
        parent::__construct($options);
    }
    
}
