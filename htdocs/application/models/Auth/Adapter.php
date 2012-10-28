<?php

class Auth_Adapter implements Zend_Auth_Adapter_Interface
{
    
    /**
     * @var string
     */
    private $_login;

    /**
     * @var string
     */
    private $_password;
    
    /**
     * @param string $login
     * @param string $password
     */
    public function __construct($login, $password)
    {
        $this->_login = $login;
        $this->_password = $password;
    }
    
    public function authenticate()
    {
        $user = is_null($this->_login) ? false : UserTable::getInstance()->findOneBy('login', $this->_login);
        if (! $user)
            return new Auth_Result(Auth_Result::FAILURE_IDENTITY_NOT_FOUND, $this->_login);

        if (! $user->checkPassword($this->_password))
            return new Auth_Result(Auth_Result::FAILURE_CREDENTIAL_INVALID, $this->_login);
        
        if (! $user->active)
            return new Auth_Result(Auth_Result::FAILURE_NOT_ACTIVE, $this->_login);

        $user->updateLastLogin();
        
        return new Auth_Result(Auth_Result::SUCCESS, $user->id);
    }
}
