<?php
/**
 * @class Acl_Assertion_User_IdExists
 */
class Acl_Assertion_User_IdExists extends Acl_Assertion_Abstract implements Zend_Acl_Assert_Interface
{
 
    public function assert(Zend_Acl $acl, Zend_Acl_Role_Interface $role = null, Zend_Acl_Resource_Interface $resource = null, $privilege = null)
    {
        $userId = $this->_getParam(FieldIdEnum::USER_ID);
                
        if (is_null($userId) || !UserTable::getInstance()->find($userId))
            return false;
            
        return true;
    }
}
