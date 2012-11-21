<?php
/**
 * @class Validate_Address_PhoneNumberRegex
 */
class Validate_Address_PhoneNumberRegex extends Zend_Validate_Regex
{

    public function __construct()
    {
        $this->_messageTemplates[self::NOT_MATCH] = Helper::getTranslator()->translate('validation_message-address_phone_number_code_regex_not_match');
        
        parent::__construct('/^[0-9 \-\+]+$/');
    }
}
