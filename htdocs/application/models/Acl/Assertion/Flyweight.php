<?php
/**
 * @class Acl_Assertion_Flyweight
 */
class Acl_Assertion_Flyweight
{
    
    /**
     * @var Zend_Acl_Assert_Interface[]
     */
    private $_assertions = array();
    
    /**
     * @var Zend_Controller_Request_Abstract 
     */
    private $_request;
    
    /**
     * @param Zend_Controller_Request_Abstract $request
     */
    public function __construct(Zend_Controller_Request_Abstract $request)
    {
        $this->_request = $request;
    }
    
    /**
     * 
     * @param String $assertionClassName    Value from Acl_Assertion_Abstract::getClassName() method.
     * @return Zend_Acl_Assert_Interface
     * @throws InvalidArgumentException     When there is no assertion with given classname;
     */
    public function getAssertion($assertionClassName)
    {
        if (!is_null($assertionClassName))
        {

            if (!array_key_exists($assertionClassName, $this->_assertions))
            {
                if (!class_exists($assertionClassName))
                    throw new InvalidArgumentException("Assertion: " . $assertionClassName . " doesn't exist.");
                
                $this->_assertions[$assertionClassName] = new $assertionClassName($this->_request->getParams());
            }

            return $this->_assertions[$assertionClassName];
        }
    }
}
