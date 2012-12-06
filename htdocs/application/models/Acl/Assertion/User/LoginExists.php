<?php
/**
 * @class Acl_Assertion_User_LoginExists
 */
class Acl_Assertion_User_LoginExists extends Acl_Assertion_Abstract implements Zend_Acl_Assert_Interface
{
 
    public function assert(Zend_Acl $acl, Zend_Acl_Role_Interface $role = null, Zend_Acl_Resource_Interface $resource = null, $privilege = null)
    {
        $userLogin = $this->_getParam(FieldIdEnum::USER_LOGIN);
        
        if (is_null($userLogin) || !UserTable::getInstance()->findOneBy('login', $userLogin))
            return false;
            
        return true;
    }
}
