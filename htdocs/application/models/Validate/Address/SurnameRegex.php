<?php
/**
 * @class Validate_Address_SurnameRegex
 */
class Validate_Address_SurnameRegex extends Zend_Validate_Regex
{
    
    public function __construct()
    {
        $this->_messageTemplates[self::NOT_MATCH] = Helper::getTranslator()->translate('validation_message-address_surname_regex_not_match');
        
        parent::__construct('/^[a-zA-ZąĄćĆęĘłŁńŃśŚóÓżŻźŹ]+[a-zA-ZąĄćĆęĘłŁńŃśŚóÓżŻźŹ \-]+$/');
    }
}
