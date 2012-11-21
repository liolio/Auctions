<?php
/**
 * @class Validate_Address_PostalCodeRegex
 */
class Validate_Address_PostalCodeRegex extends Zend_Validate_Regex
{
    
    public function __construct()
    {
        $this->_messageTemplates[self::NOT_MATCH] = Helper::getTranslator()->translate('validation_message-address_postal_code_regex_not_match');
        
        parent::__construct('/^[a-zA-ZąĄćĆęĘłŁńŃśŚóÓżŻźŹ0-9 \-]+$/');
    }
}
