<?php
/**
 * @class Acl_Assertion_Container_Abstract
 */
class Acl_Assertion_Container_Abstract
{
    
    /**
     * @var Zend_Acl_Assert_Interface[]
     */
    private $_assertions = array();
    
    public function addAssertion(Zend_Acl_Assert_Interface $assertion)
    {
        $this->_assertions[] = $assertion;
        
        return $this;
    }
    
    protected function _getAssertions()
    {
        return $this->_assertions;
    }
}
