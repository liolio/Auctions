<?php
/**
 * @class User
 */
class User extends BaseUser implements Notification_RelatedObject_Interface
{
    
    const SALT_MIN = '00421';
    
    const SALT_MAX = '29874';
    
    public function getRelatedObjectId()
    {
        return $this->id;
    }
    
    public function getRecipients()
    {
        return array($this->email);
    }
    
    public function getNotificationData($notificationType)
    {
        switch ($notificationType)
        {
            case Enum_Db_Notification_Type::USER_NEW_PASSWORD_SET :
                return array(
                    FieldIdEnum::USER_LOGIN     =>  $this->login,
                    ParamIdEnum::USER_FULLNAME  =>  $this->getFullName()
                );
                
            case Enum_Db_Notification_Type::USER_PASSWORD_RESET :
            case Enum_Db_Notification_Type::USER_REGISTRATION :
                return array(
                    FieldIdEnum::USER_LOGIN     =>  $this->login,
                    ParamIdEnum::USER_FULLNAME  =>  $this->getFullName(),
                    ParamIdEnum::LINK           =>  Controller_Front_UrlGenerator::generate($notificationType, $this->secret_code)
                );
                
            default :
                throw new InvalidArgumentException('Notification type ' . $notificationType . ' is not supported.');
        }
    }
    
    /**
     * Returns name and surname.
     * 
     * @return String
     */
    public function getFullName()
    {
        $address = $this->Addresses->getFirst();
        return $address->name . " " . $address->surname;
    }

    /**
     * Veryfies if given value quals user's password.
     * 
     * @param string $password
     * @return boolean
     */
    public function checkPassword($password)
    {
        return $this->password === sha1($this->salt . $password);
    }
    
    /**
     * Sets given value as password.
     * 
     * @param type $password
     * @return User
     */
    public function setNewPassword($password)
    {
        $this->password = sha1($this->salt . $password);
        
        return $this;
    }
    
    /**
     * Sets active to true.
     * 
     * @return User
     */
    public function activateAccount()
    {
        $this->active = true;
        
        return $this;
    }
    
    /**
     * Resets secret code.
     * 
     * @return User
     */
    public function resetSecretCode()
    {
        $this->secret_code = null;
        
        return $this;
    }
    
    /**
     * Sets and saves new secret code.
     * 
     * @return User
     */
    public function setNewSecretCode()
    {
        $this->secret_code = User_SecurityCode_Generator::generate();
        $this->save();
        $this->refresh();
        
        return $this;
    }
    
    /**
     * 
     * @return User
     */
    public function updateLastLogin()
    {
        $this->refresh(true);
        $this->last_login = Zend_Date::now()->toString(Time_Format::getFullDateTimeFormat());
        $this->save();
        
        return $this;
    }
}
