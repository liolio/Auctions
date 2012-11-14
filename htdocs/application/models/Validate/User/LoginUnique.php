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
    
    public function isValid($value)
    {
        $usersCount = UserTable::getInstance()->findBy('login', $value)->count();
        
        if ($usersCount > 0)
        {
            $this->_error(self::LOGIN_EXISTS);
            return false;
        }
        
        return true;
    }
}
