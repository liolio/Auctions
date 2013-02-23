<?php
/**
 * @class Validate_NotEmpty
 */
class Validate_NotEmpty extends Zend_Validate_NotEmpty
{
    
    public function __construct($options = array())
    {
        $this->_messageTemplates[self::IS_EMPTY] = Helper::getTranslator()->translate('validation_message-field_empty');
        $this->_messageTemplates[self::INVALID] = str_replace(
            '%%types%%',
            'string, integer, float, boolean, array',
            Helper::getTranslator()->translate('validation_message-invalid_type')
        );
        
        parent::__construct($options);
    }
}
