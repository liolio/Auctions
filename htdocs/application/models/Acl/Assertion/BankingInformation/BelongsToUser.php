<?php
/**
 * @class Acl_Assertion_BankingInformation_BelongsToUser
 */
class Acl_Assertion_BankingInformation_BelongsToUser extends Acl_Assertion_Abstract implements Zend_Acl_Assert_Interface
{
    
    public function assert(Zend_Acl $acl, Zend_Acl_Role_Interface $role = null, Zend_Acl_Resource_Interface $resource = null, $privilege = null)
    {
        if (is_null($this->_getParam(FieldIdEnum::BANKING_INFORMATION_ID)))
            return false;
        
        $bankingInformation = BankingInformationTable::getInstance()->findOneBy("id", $this->_getParam(FieldIdEnum::BANKING_INFORMATION_ID));
        
        if ($bankingInformation !== false) 
            return Auth_User::getInstance()->getUser()->id === $bankingInformation->user_id;
        
        return false;
    }

}
