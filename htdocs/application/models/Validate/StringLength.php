<?php
/**
 * @class Validate_StringLength
 */
class Validate_StringLength extends Zend_Validate_StringLength
{
    
    public function __construct($options = array())
    {
        $this->_messageTemplates[self::INVALID] = str_replace('%%types%%', 'string', Helper::getTranslator()->translate('validation_message-invalid_type'));
        $this->_messageTemplates[self::TOO_SHORT] = Helper::getTranslator()->translate('validation_message-too_short');
        $this->_messageTemplates[self::TOO_LONG] = Helper::getTranslator()->translate('validation_message-too_long');
        
        parent::__construct($options);
    }
}
