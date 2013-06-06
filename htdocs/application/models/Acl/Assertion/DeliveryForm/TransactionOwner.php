<?php
/**
 * @class Acl_Assertion_DeliveryForm_TransactionOwner
 */
class Acl_Assertion_DeliveryForm_TransactionOwner extends Acl_Assertion_Abstract implements Zend_Acl_Assert_Interface
{
    
    public function assert(Zend_Acl $acl, Zend_Acl_Role_Interface $role = null, Zend_Acl_Resource_Interface $resource = null, $privilege = null)
    {
        $deliveryFormId = $this->_getParam(FieldIdEnum::DELIVERY_FORM_ID);
        
        if (is_null($deliveryFormId))
            return false;
        
        $deliveryForm = DeliveryFormTable::getInstance()->find($deliveryFormId);
        
        if ($deliveryForm !== false)
            return Auth_User::getInstance()->getUser()->id === $deliveryForm->Transaction->User->id;
        
        return false;
    }
}
