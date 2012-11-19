<?php
/**
 * @class Auth_User
 */
class Auth_User
{
    
    /**
     * @var Auth_User
     */
    private static $_instance;
    
    /**
     * @var User
     */
    private $_user;
    
    /**
     * 
     * @return Auth_User
     */
    public static function getInstance()
    {
        if (is_null(self::$_instance))
            self::$_instance = new self();
        
        return self::$_instance;
    }
    
    /**
     * Returns user stored in session.
     * 
     * @return User
     */
    public function getUser()
    {
        if (!Zend_Auth::getInstance()->hasIdentity())
            return null;
        
        if (is_null($this->_user))
            $this->_user = UserTable::getInstance()->findOneBy('id', Zend_Auth::getInstance()->getIdentity());
        
        return $this->_user;
    }
    
    /**
     * Clears user from session.
     * 
     * @return Auth_User
     */
    public function clearUser()
    {
        $this->_user = null;
        
        return $this;
    }
    
    private function __construct()
    {
        
    }
}
