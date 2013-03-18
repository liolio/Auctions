<?php
/**
 * @class Acl
 */
class Acl extends Zend_Acl
{
    
    /**
     * @var Zend_Controller_Request_Abstract 
     */
    private $_request;
    
    /**
     * @var Acl_Assertion_Flyweight
     */
    private $_assertionFlyweight;
    
    public function __construct()
    {
        $this->_request = Zend_Controller_Front::getInstance()->getRequest();
        $this->_assertionFlyweight = new Acl_Assertion_Flyweight($this->_request);
        $this->_addRoles();
        $this->_addResources();
        $this->_addAllows();
    }
    
    private function _addRoles()
    {
        $this->addRole(Enum_Acl_Role::GUEST);
        $this->addRole(Enum_Acl_Role::USER, Enum_Acl_Role::GUEST);
        $this->addRole(Enum_Acl_Role::MODERATOR, Enum_Acl_Role::USER);
        $this->addRole(Enum_Acl_Role::ADMINISTRATOR, Enum_Acl_Role::MODERATOR);
    }
    
    private function _addResources()
    {
        $this->addResource('Auctions:Auth');
        $this->addResource('Auctions:Error');
        $this->addResource('Auctions:Index');
        $this->addResource('Auctions:User');
        $this->addResource('Auctions:Address');
    }
    
    private function _addAllows()
    {
        //GUEST
        $this->_allow(Enum_Acl_Role::GUEST, 'Auctions:Auth', array('index', 'process'));
        $this->_allow(Enum_Acl_Role::GUEST, 'Auctions:Error', array('error'));
        $this->_allow(Enum_Acl_Role::GUEST, 'Auctions:Index', array('index'));
        $this->_allow(Enum_Acl_Role::GUEST, 'Auctions:User', array('registration', 'process-registration-form', 'password-reset-request', 'process-password-reset-form'));
        $this->_allow(Enum_Acl_Role::GUEST, 'Auctions:User', array('process-set-password-and-activate-account-form'), Acl_Assertion_User_LoginExists::getClassName());
        $this->_allow(Enum_Acl_Role::GUEST, 'Auctions:User', array('set-password-and-register-account'), Acl_Assertion_User_SecretCodeExists::getClassName());
        
        //USER
        $this->_allow(Enum_Acl_Role::USER, 'Auctions:Auth', array('logout'));
        $this->_allow(Enum_Acl_Role::USER, 'Auctions:User', array('panel', 'change-password'));
        $this->_allow(Enum_Acl_Role::USER, 'Auctions:Address', array('show-list', 'add', 'process-add-form', 'delete'));
        $this->_allow(Enum_Acl_Role::USER, 'Auctions:User', array('process-change-password'), Acl_Assertion_User_LoginExists::getClassName());
    }
    
    private function _allow($roles = null, $resources = null, $privileges = null, $assertionClassName = null)
    {
        foreach ($privileges as $privilege)
        {
            if (
                $resources === Controller_Front_Request::getResource($this->_request) &&
                $privilege === Controller_Front_Request::getPrivilege($this->_request)
            )
            {
                $this->allow($roles, $resources, $privileges, $this->_assertionFlyweight->getAssertion($assertionClassName));
                break;
            }
        }
    }
}
