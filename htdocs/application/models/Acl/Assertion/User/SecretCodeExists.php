<?php
/**
 * @class Acl_Assertion_User_SecretCodeExists
 */
class Acl_Assertion_User_SecretCodeExists extends Acl_Assertion_Abstract implements Zend_Acl_Assert_Interface
{
 
    public function assert(Zend_Acl $acl, Zend_Acl_Role_Interface $role = null, Zend_Acl_Resource_Interface $resource = null, $privilege = null)
    {
        $userSecretCode = $this->_getParam(FieldIdEnum::USER_SECRET_CODE);
        
        if (is_null($userSecretCode) || !UserTable::getInstance()->findOneBy('secret_code', $userSecretCode))   
            return false;
            
        return true;
    }
}
