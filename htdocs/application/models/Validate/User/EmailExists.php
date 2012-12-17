<?php
/**
 * @class Validate_User_EmailExists
 */
class Validate_User_EmailExists extends Zend_Validate_Abstract
{
    const EMAIL_NOT_EXISTS = 'emailNotExists';

    protected $_messageTemplates = array(
        self::EMAIL_NOT_EXISTS      =>  'validation_message-user_email_not_exists',
    );
    
    public function isValid($value)
    {
        $usersCount = UserTable::getInstance()->findBy('email', $value)->count();
        
        if ($usersCount == 0)
        {
            $this->_error(self::EMAIL_NOT_EXISTS);
            return false;
        }
        
        return true;
    }
}
