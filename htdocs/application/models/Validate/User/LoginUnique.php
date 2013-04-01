<?php
/**
 * @class Validate_User_LoginUnique
 */
class Validate_User_LoginUnique extends Zend_Validate_Abstract
{
    const LOGIN_EXISTS = 'loginExists';

    protected $_messageTemplates = array(
        self::LOGIN_EXISTS      =>  'validation_message-user_login_exists',
    );
    
    public function isValid($value, $context = null)
    {
        $userId = array_key_exists(FieldIdEnum::USER_ID, $context) ? $context[FieldIdEnum::USER_ID] : null;
        if (!UserTable::getInstance()->isLoginUnique($value, $userId))
        {
            $this->_error(self::LOGIN_EXISTS);
            return false;
        }
        
        return true;
    }
}
