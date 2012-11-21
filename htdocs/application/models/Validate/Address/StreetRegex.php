<?php
/**
 * @class Validate_Address_StreetRegex
 */
class Validate_Address_StreetRegex extends Zend_Validate_Regex
{
    
    public function __construct()
    {
        $this->_messageTemplates[self::NOT_MATCH] = Helper::getTranslator()->translate('validation_message-address_street_regex_not_match');
        
        parent::__construct('/^[a-zA-Z0-9ąĄćĆęĘłŁńŃśŚóÓżŻźŹ]+[a-zA-Z0-9ąĄćĆęĘłŁńŃśŚóÓżŻźŹ \-\/\.]+$/');
    }
}
