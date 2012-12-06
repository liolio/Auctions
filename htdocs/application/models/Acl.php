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
        $this->addRole(Acl_RoleEnum::GUEST);
        $this->addRole(Acl_RoleEnum::USER, Acl_RoleEnum::GUEST);
        $this->addRole(Acl_RoleEnum::MODERATOR, Acl_RoleEnum::USER);
        $this->addRole(Acl_RoleEnum::ADMINISTRATOR, Acl_RoleEnum::MODERATOR);
    }
    
    private function _addResources()
    {
        $this->addResource('Auctions:Auth');
        $this->addResource('Auctions:Error');
        $this->addResource('Auctions:Index');
        $this->addResource('Auctions:User');
    }
    
    private function _addAllows()
    {
        //GUEST
        $this->_allow(Acl_RoleEnum::GUEST, 'Auctions:Auth', array('index', 'process'));
        $this->_allow(Acl_RoleEnum::GUEST, 'Auctions:Error', array('error'));
        $this->_allow(Acl_RoleEnum::GUEST, 'Auctions:Index', array('index'));
        $this->_allow(Acl_RoleEnum::GUEST, 'Auctions:User', array('registration', 'process-registration-form'));
        $this->_allow(Acl_RoleEnum::GUEST, 'Auctions:User', array('process-change-password-and-activate-account-form'), Acl_Assertion_User_LoginExists::getClassName());
        $this->_allow(Acl_RoleEnum::GUEST, 'Auctions:User', array('set-password-and-register-account'), Acl_Assertion_User_SecretCodeExists::getClassName());
        
        //USER
        $this->_allow(Acl_RoleEnum::USER, 'Auctions:Auth', array('logout'));
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
