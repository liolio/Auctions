<?php
/**
 * @class Validate_User_EmailUnique
 */
class Validate_User_EmailUnique extends Zend_Validate_Abstract
{
    const EMAIL_EXISTS = 'emailExists';

    protected $_messageTemplates = array(
        self::EMAIL_EXISTS      =>  'validation_message-user_email_exists',
    );
    
    public function isValid($value, $context = null)
    {
        $userId = array_key_exists(FieldIdEnum::USER_ID, $context) ? $context[FieldIdEnum::USER_ID] : null;
        if (!UserTable::getInstance()->isEmailUnique($value, $userId))
        {
            $this->_error(self::EMAIL_EXISTS);
            return false;
        }
        
        return true;
    }
}
