<?php
/**
 * @class Acl_Assertion_Container_Or
 */
class Acl_Assertion_Container_Or extends Acl_Assertion_Container_Abstract implements Zend_Acl_Assert_Interface
{
    
    public function assert(Zend_Acl $acl, Zend_Acl_Role_Interface $role = null, Zend_Acl_Resource_Interface $resource = null, $privilege = null)
    {
        foreach ($this->_getAssertions() as $assertion)
        {
            if ($assertion->assert($acl, $role, $resource, $privilege))
                return true;
        }
        
        return false;
    }
}
