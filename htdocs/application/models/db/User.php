<?php

/**
 * User
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7691 2011-02-04 15:43:29Z jwage $
 */
class User extends BaseUser implements Notification_RelatedObject_Interface
{
    
    const SALT_MIN = '00421';
    
    const SALT_MAX = '29874';
    
    public function getId()
    {
//        return $this->id;
    }
    
    public function getNotificationData($notificationType)
    {
        return array(
            FieldIdEnum::USER_LOGIN =>  $this->login,
            ParamIdEnum::LINK       =>  Notification_Link_Generator::generate($notificationType, $this->secret_code)
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