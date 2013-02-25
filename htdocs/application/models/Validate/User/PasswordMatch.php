<?php
/**
 * @class Validate_User_PasswordMatch
 */
class Validate_User_PasswordMatch extends Zend_Validate_Abstract
{
    const PASSWORD_NOT_MATCH = 'passwordNotMatch';

    protected $_messageTemplates = array(
        self::PASSWORD_NOT_MATCH      =>  'validation_message-user_password_not_match',
    );
    
    public function isValid($value, $context = null)
    {
        $user = UserTable::getInstance()->findOneBy('login', $context[FieldIdEnum::USER_LOGIN]);
        
        if ($user !== false && $user->checkPassword($value))
            return true;
        
        $this->_error(self::PASSWORD_NOT_MATCH);
        return false;
    }
}
