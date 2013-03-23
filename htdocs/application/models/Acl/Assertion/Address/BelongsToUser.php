<?php
/**
 * @class Acl_Assertion_Address_BelongsToUser
 */
class Acl_Assertion_Address_BelongsToUser extends Acl_Assertion_Abstract implements Zend_Acl_Assert_Interface
{
    
    public function assert(Zend_Acl $acl, Zend_Acl_Role_Interface $role = null, Zend_Acl_Resource_Interface $resource = null, $privilege = null)
    {
        if (is_null($this->_getParam(FieldIdEnum::ADDRESS_ID)))
            return false;
        
        $address = AddressTable::getInstance()->findOneBy("id", $this->_getParam(FieldIdEnum::ADDRESS_ID));
        
        if ($address !== false) 
        {
            return Auth_User::getInstance()->getUser()->id === $address->user_id;
        }
        
        return false;
    }

}
