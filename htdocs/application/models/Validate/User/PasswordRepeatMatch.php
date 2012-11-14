<?php
/**
 * @class Validate_User_PasswordRepeatMatch
 */
class Validate_User_PasswordRepeatMatch extends Zend_Validate_Abstract
{
    const PASSWORD_NOT_MATCH = 'passwordNotMatch';

    protected $_messageTemplates = array(
        self::PASSWORD_NOT_MATCH      =>  'validation_message-user_passwords_not_match',
    );
    
    public function isValid($value, $context = null)
    {
        if ($value !== $context[FieldIdEnum::USER_PASSWORD])
        {
            $this->_error(self::PASSWORD_NOT_MATCH);
            return false;
        }
        
        return true;
    }
}
