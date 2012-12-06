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
    
    public function getNotificationData($notificationType)
    {
        return array(
            FieldIdEnum::USER_LOGIN =>  $this->login,
            ParamIdEnum::LINK       =>  Controller_Front_UrlGenerator::generate($notificationType, $this->secret_code)
        );
    }

    public function getRecipients()
    {
        return array($this->email);
    }
    
    /**
     * 
     * @param string $password
     * @return boolean
     */
    public function checkPassword($password)
    {
        return $this->password === sha1($this->salt . $password);
    }
    
    public function setNewPassword($password)
    {
        $this->password = sha1($this->salt . $password);
        
        return $this;
    }
    
    public function activateAccount()
    {
        $this->active = true;
        
        return $this;
    }
    
    public function resetSecretCode()
    {
        $this->secret_code = null;
        
        return $this;
    }
    
    /**
     * 
     * @return User
     */
    public function updateLastLogin()
    {
        $this->last_login = Zend_Date::now()->toString(Time_Format::getFullDateTimeFormat());
        $this->save();
        
        return $this;
    }
}
