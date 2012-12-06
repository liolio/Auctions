<?php
/**
 * @class Acl_Assertion_Container_And
 */
class Acl_Assertion_Container_And extends Acl_Assertion_Container_Abstract
{
    
    public function assert(Zend_Acl $acl, Zend_Acl_Role_Interface $role = null, Zend_Acl_Resource_Interface $resource = null, $privilege = null)
    {
        foreach ($this->_getAssertions() as $assertion)
        {
            if (!$assertion->assert($acl, $role, $resource, $privilege))
                return false;
        }
        
        return true;
    }
}
