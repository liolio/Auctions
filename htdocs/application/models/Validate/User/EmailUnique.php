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
    
    public function isValid($value)
    {
        $usersCount = UserTable::getInstance()->findBy('email', $value)->count();
        
        if ($usersCount > 0)
        {
            $this->_error(self::EMAIL_EXISTS);
            return false;
        }
        
        return true;
    }
}
