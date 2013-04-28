<?php
/**
 * @class Validate_Date
 */
class Validate_Date extends Zend_Validate_Date
{

    public function __construct($options = array())
    {
        $this->_messageTemplates[self::INVALID] = Helper::getTranslator()->translate('validation_message-date_invalid_type');
        $this->_messageTemplates[self::INVALID_DATE] = Helper::getTranslator()->translate('validation_message-date_invalid_date');
        $this->_messageTemplates[self::FALSEFORMAT] = Helper::getTranslator()->translate('validation_message-date_false_format');
        
        parent::__construct($options);
    }
    
}
