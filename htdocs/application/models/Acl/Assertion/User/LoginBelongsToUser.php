<?php
/**
 * @class Acl_Assertion_User_LoginBelongsToUser
 */
class Acl_Assertion_User_LoginBelongsToUser extends Acl_Assertion_Abstract implements Zend_Acl_Assert_Interface
{
 
    public function assert(Zend_Acl $acl, Zend_Acl_Role_Interface $role = null, Zend_Acl_Resource_Interface $resource = null, $privilege = null)
    {
        $user = Auth_User::getInstance()->getUser();
        
        if (is_null($user))
            return false;
        
        return $this->_getParam(FieldIdEnum::USER_LOGIN) === $user->login;
    }
}

