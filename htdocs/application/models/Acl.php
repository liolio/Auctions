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
        $this->addResource(Enum_Acl_Resource::ADDRESS);
        $this->addResource(Enum_Acl_Resource::ADMINISTRATOR);
        $this->addResource(Enum_Acl_Resource::AUCTION);
        $this->addResource(Enum_Acl_Resource::AUTH);
        $this->addResource(Enum_Acl_Resource::BANKING_INFORMATION);
        $this->addResource(Enum_Acl_Resource::CATEGORY);
        $this->addResource(Enum_Acl_Resource::CURRENCY);
        $this->addResource(Enum_Acl_Resource::DELIVERY_FORM);
        $this->addResource(Enum_Acl_Resource::DELIVERY_TYPE);
        $this->addResource(Enum_Acl_Resource::ERROR);
        $this->addResource(Enum_Acl_Resource::FILE);
        $this->addResource(Enum_Acl_Resource::INDEX);
        $this->addResource(Enum_Acl_Resource::NEWS);
        $this->addResource(Enum_Acl_Resource::TRANSACTION);
        $this->addResource(Enum_Acl_Resource::USER);
    }
    
    private function _addAllows()
    {
        //GUEST
        $this->_allow(Enum_Acl_Role::GUEST, Enum_Acl_Resource::AUTH, array('index', 'process'));
        $this->_allow(Enum_Acl_Role::GUEST, Enum_Acl_Resource::ERROR, array('error'));
        $this->_allow(Enum_Acl_Role::GUEST, Enum_Acl_Resource::INDEX, array('index'));
        $this->_allow(Enum_Acl_Role::GUEST, Enum_Acl_Resource::USER, array('registration', 'process-registration-form', 'password-reset-request', 'process-password-reset-form'));
        $this->_allow(Enum_Acl_Role::GUEST, Enum_Acl_Resource::USER, array('show'), Acl_Assertion_User_IdExists::getClassName());
        $this->_allow(Enum_Acl_Role::GUEST, Enum_Acl_Resource::USER, array('process-set-password-and-activate-account-form'), Acl_Assertion_User_LoginExists::getClassName());
        $this->_allow(Enum_Acl_Role::GUEST, Enum_Acl_Resource::USER, array('set-password-and-register-account'), Acl_Assertion_User_SecretCodeExists::getClassName());
        $this->_allow(Enum_Acl_Role::GUEST, Enum_Acl_Resource::AUCTION, array('show-list-for-category', 'show'));
        $this->_allow(Enum_Acl_Role::GUEST, Enum_Acl_Resource::TRANSACTION, array('bid', 'buy-out'));
        $this->_allow(Enum_Acl_Role::GUEST, Enum_Acl_Resource::DELIVERY_FORM, array('fill'));
        
        //USER
        $this->_allow(Enum_Acl_Role::USER, Enum_Acl_Resource::AUTH, array('logout'));
        $this->_allow(Enum_Acl_Role::USER, Enum_Acl_Resource::USER, array('panel', 'change-password'));
        $this->_allow(Enum_Acl_Role::USER, Enum_Acl_Resource::USER, array('process-change-password'), Acl_Assertion_User_LoginBelongsToUser::getClassName());
        $this->_allow(Enum_Acl_Role::USER, Enum_Acl_Resource::ADDRESS, array('show-list', 'add', 'process-add-form'));
        $this->_allow(Enum_Acl_Role::USER, Enum_Acl_Resource::ADDRESS, array('delete', 'edit', 'process-edit-form'), Acl_Assertion_Address_BelongsToUser::getClassName());
        $this->_allow(Enum_Acl_Role::USER, Enum_Acl_Resource::BANKING_INFORMATION, array('show-list', 'add', 'process-add-form'));
        $this->_allow(Enum_Acl_Role::USER, Enum_Acl_Resource::BANKING_INFORMATION, array('delete', 'edit', 'process-edit-form'), Acl_Assertion_BankingInformation_BelongsToUser::getClassName());
        $this->_allow(Enum_Acl_Role::USER, Enum_Acl_Resource::AUCTION, array('add', 'process-add-form', 'my-auctions-list'));
        $this->_allow(Enum_Acl_Role::USER, Enum_Acl_Resource::TRANSACTION, array('process-transaction-form'));
        $this->_allow(Enum_Acl_Role::USER, Enum_Acl_Resource::DELIVERY_FORM, array('process-add-form'), Acl_Assertion_DeliveryForm_TransactionOwner::getClassName());
        $this->_allow(Enum_Acl_Role::USER, Enum_Acl_Resource::DELIVERY_FORM, array('show-list', 'process', 'process-process-form'));
        
        //ADMINISTRATOR
        $this->_allow(Enum_Acl_Role::ADMINISTRATOR, Enum_Acl_Resource::ADMINISTRATOR, array('index'));
        $this->_allow(Enum_Acl_Role::ADMINISTRATOR, Enum_Acl_Resource::CATEGORY, array('show-administrator-list', 'add', 'process-add-form', 'edit', 'process-edit-form', 'delete'));
        $this->_allow(Enum_Acl_Role::ADMINISTRATOR, Enum_Acl_Resource::CURRENCY, array('show-administrator-list', 'add', 'process-add-form', 'edit', 'process-edit-form', 'delete'));
        $this->_allow(Enum_Acl_Role::ADMINISTRATOR, Enum_Acl_Resource::USER, array('show-list', 'reset-password-by-administrator', 'delete', 'edit', 'process-edit-form'));
        $this->_allow(Enum_Acl_Role::ADMINISTRATOR, Enum_Acl_Resource::FILE, array('add', 'process-add-form'));
        $this->_allow(Enum_Acl_Role::ADMINISTRATOR, Enum_Acl_Resource::DELIVERY_TYPE, array('show-administrator-list', 'add', 'process-add-form', 'edit', 'process-edit-form', 'delete'));
        $this->_allow(Enum_Acl_Role::ADMINISTRATOR, Enum_Acl_Resource::NEWS, array('show-list', 'add', 'process-add-form', 'edit', 'process-edit-form', 'delete'));
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
