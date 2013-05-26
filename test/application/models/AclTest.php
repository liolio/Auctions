<?php
/**
 * @class AclTest
 */
class AclTest extends TestCase_Controller
{

    /**
     * @var array
     */
    private $_roles;
    
    public function __construct($name = NULL, array $data = array(), $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->_roles = $this->_getRoles();
    }
    
    /**
     * @test
     * @dataProvider dataProvider
     */
    public function isAllowedTest(array $roles, $resource, $action, array $requestParams = array(), array $fixtures = array())
    {
        $this->_loadFixtures($fixtures);
        
        foreach ($roles as $role => $expectedResult)
            $this->assertEquals(
                $expectedResult, 
                $this->_getAcl($resource, $action, $requestParams)->isAllowed($role, $resource, $action), 
                "Failure for role: " . $role
            );
    }
    
    /**
     * @test
     * @dataProvider dataProvider
     */
    public function isAllowedWithoutParams(array $roles, $resource, $action, array $requestParams = array(), array $fixtures = array())
    {
        if (count($requestParams) > 0)
        {
            $this->_loadFixtures($fixtures);
            
            foreach (array_keys($roles) as $role)
            {
                if ($role !== Enum_Acl_Role::GUEST)
                {
                    $this->_logInAdminUser();
                    Auth_User::getInstance()->getUser()->role = $role;
                }
                else 
                    Auth_User::getInstance()->clearUser();
            
                $this->assertEquals(
                    false, 
                    $this->_getAcl($resource, $action, array())->isAllowed($role, $resource, $action), 
                    "Failure for role: " . $role
                );
            }
        }
    }
    
    private function _getAcl($resource, $action, $requestParams)
    {
        $request = new Zend_Controller_Request_Http();
        $request->setModuleName('auctions');
        $request->setControllerName(Enum_Acl_Resource::getControllerName($resource));
        $request->setActionName($action);
        $request->setParams($requestParams);
        
        Zend_Controller_Front::getInstance()->setRequest($request);
        
        return new Acl();
    }
    
    public function dataProvider()
    {
        return array(
            // GUEST
            array($this->_roles[Enum_Acl_Role::GUEST], Enum_Acl_Resource::AUTH, 'index'),
            array($this->_roles[Enum_Acl_Role::GUEST], Enum_Acl_Resource::AUTH, 'process'),
            array($this->_roles[Enum_Acl_Role::GUEST], Enum_Acl_Resource::ERROR, 'error'),
            array($this->_roles[Enum_Acl_Role::GUEST], Enum_Acl_Resource::INDEX, 'index'),
            array($this->_roles[Enum_Acl_Role::GUEST], Enum_Acl_Resource::USER, 'registration'),
            array($this->_roles[Enum_Acl_Role::GUEST], Enum_Acl_Resource::USER, 'process-registration-form'),
            array($this->_roles[Enum_Acl_Role::GUEST], Enum_Acl_Resource::USER, 'password-reset-request'),
            array($this->_roles[Enum_Acl_Role::GUEST], Enum_Acl_Resource::USER, 'process-password-reset-form'),
            array($this->_roles[Enum_Acl_Role::GUEST], Enum_Acl_Resource::USER, 'process-set-password-and-activate-account-form', array(FieldIdEnum::USER_LOGIN => 'admin')),
            array($this->_roles[Enum_Acl_Role::GUEST], Enum_Acl_Resource::USER, 'set-password-and-register-account', array(FieldIdEnum::USER_SECRET_CODE => '123qwe')),
            array($this->_roles[Enum_Acl_Role::GUEST], Enum_Acl_Resource::AUCTION, 'show-list-for-category'),
            array($this->_roles[Enum_Acl_Role::GUEST], Enum_Acl_Resource::AUCTION, 'show', array(FieldIdEnum::AUCTION_ID => '4'), array("Category/1", "Currency/1", "Auction/4_category_1_start_now-1")),
            array($this->_roles[Enum_Acl_Role::GUEST], Enum_Acl_Resource::TRANSACTION, 'bid'),
            array($this->_roles[Enum_Acl_Role::GUEST], Enum_Acl_Resource::TRANSACTION, 'buy-out'),
            
            // USER
            array($this->_roles[Enum_Acl_Role::USER], Enum_Acl_Resource::AUTH, 'logout'),
            array($this->_roles[Enum_Acl_Role::USER], Enum_Acl_Resource::USER, 'panel'),
            array($this->_roles[Enum_Acl_Role::USER], Enum_Acl_Resource::USER, 'change-password'),
            array($this->_roles[Enum_Acl_Role::USER], Enum_Acl_Resource::USER, 'process-change-password', array(FieldIdEnum::USER_LOGIN   =>  'admin')),
            array($this->_roles[Enum_Acl_Role::USER], Enum_Acl_Resource::ADDRESS, 'show-list'),
            array($this->_roles[Enum_Acl_Role::USER], Enum_Acl_Resource::ADDRESS, 'add'),
            array($this->_roles[Enum_Acl_Role::USER], Enum_Acl_Resource::ADDRESS, 'process-add-form'),
            array($this->_roles[Enum_Acl_Role::USER], Enum_Acl_Resource::ADDRESS, 'delete', array(FieldIdEnum::ADDRESS_ID => '1')),
            array($this->_roles[Enum_Acl_Role::USER], Enum_Acl_Resource::ADDRESS, 'edit', array(FieldIdEnum::ADDRESS_ID => '1')),
            array($this->_roles[Enum_Acl_Role::USER], Enum_Acl_Resource::ADDRESS, 'process-edit-form', array(FieldIdEnum::ADDRESS_ID => '1')),
            array($this->_roles[Enum_Acl_Role::USER], Enum_Acl_Resource::BANKING_INFORMATION, 'show-list'),
            array($this->_roles[Enum_Acl_Role::USER], Enum_Acl_Resource::BANKING_INFORMATION, 'add'),
            array($this->_roles[Enum_Acl_Role::USER], Enum_Acl_Resource::BANKING_INFORMATION, 'process-add-form'),
            array($this->_roles[Enum_Acl_Role::USER], Enum_Acl_Resource::BANKING_INFORMATION, 'delete', array(FieldIdEnum::BANKING_INFORMATION_ID => '1'), array('Currency/1', 'BankingInformation/1_currency_1_user_1')),
            array($this->_roles[Enum_Acl_Role::USER], Enum_Acl_Resource::AUCTION, 'add'),
            array($this->_roles[Enum_Acl_Role::USER], Enum_Acl_Resource::AUCTION, 'process-add-form'),
            array($this->_roles[Enum_Acl_Role::USER], Enum_Acl_Resource::TRANSACTION, 'process-transaction-form'),
            
            // ADMINISTRATOR
            array($this->_roles[Enum_Acl_Role::ADMINISTRATOR], Enum_Acl_Resource::ADMINISTRATOR, 'index'),
            array($this->_roles[Enum_Acl_Role::ADMINISTRATOR], Enum_Acl_Resource::CATEGORY, 'show-administrator-list'),
            array($this->_roles[Enum_Acl_Role::ADMINISTRATOR], Enum_Acl_Resource::CATEGORY, 'add'),
            array($this->_roles[Enum_Acl_Role::ADMINISTRATOR], Enum_Acl_Resource::CATEGORY, 'process-add-form'),
            array($this->_roles[Enum_Acl_Role::ADMINISTRATOR], Enum_Acl_Resource::CATEGORY, 'edit'),
            array($this->_roles[Enum_Acl_Role::ADMINISTRATOR], Enum_Acl_Resource::CATEGORY, 'process-edit-form'),
            array($this->_roles[Enum_Acl_Role::ADMINISTRATOR], Enum_Acl_Resource::CATEGORY, 'delete'),
            array($this->_roles[Enum_Acl_Role::ADMINISTRATOR], Enum_Acl_Resource::CURRENCY, 'show-administrator-list'),
            array($this->_roles[Enum_Acl_Role::ADMINISTRATOR], Enum_Acl_Resource::CURRENCY, 'add'),
            array($this->_roles[Enum_Acl_Role::ADMINISTRATOR], Enum_Acl_Resource::CURRENCY, 'process-add-form'),
            array($this->_roles[Enum_Acl_Role::ADMINISTRATOR], Enum_Acl_Resource::CURRENCY, 'edit'),
            array($this->_roles[Enum_Acl_Role::ADMINISTRATOR], Enum_Acl_Resource::CURRENCY, 'process-edit-form'),
            array($this->_roles[Enum_Acl_Role::ADMINISTRATOR], Enum_Acl_Resource::CURRENCY, 'delete'),
            array($this->_roles[Enum_Acl_Role::ADMINISTRATOR], Enum_Acl_Resource::USER, 'show-list'),
            array($this->_roles[Enum_Acl_Role::ADMINISTRATOR], Enum_Acl_Resource::USER, 'reset-password-by-administrator'),
            array($this->_roles[Enum_Acl_Role::ADMINISTRATOR], Enum_Acl_Resource::USER, 'delete'),
            array($this->_roles[Enum_Acl_Role::ADMINISTRATOR], Enum_Acl_Resource::USER, 'edit'),
            array($this->_roles[Enum_Acl_Role::ADMINISTRATOR], Enum_Acl_Resource::USER, 'process-edit-form'),
            array($this->_roles[Enum_Acl_Role::ADMINISTRATOR], Enum_Acl_Resource::FILE, 'add'),
            array($this->_roles[Enum_Acl_Role::ADMINISTRATOR], Enum_Acl_Resource::FILE, 'process-add-form'),
            array($this->_roles[Enum_Acl_Role::ADMINISTRATOR], Enum_Acl_Resource::DELIVERY_TYPE, 'show-administrator-list'),
            array($this->_roles[Enum_Acl_Role::ADMINISTRATOR], Enum_Acl_Resource::DELIVERY_TYPE, 'add'),
            array($this->_roles[Enum_Acl_Role::ADMINISTRATOR], Enum_Acl_Resource::DELIVERY_TYPE, 'process-add-form'),
            array($this->_roles[Enum_Acl_Role::ADMINISTRATOR], Enum_Acl_Resource::DELIVERY_TYPE, 'edit'),
            array($this->_roles[Enum_Acl_Role::ADMINISTRATOR], Enum_Acl_Resource::DELIVERY_TYPE, 'process-edit-form'),
            array($this->_roles[Enum_Acl_Role::ADMINISTRATOR], Enum_Acl_Resource::DELIVERY_TYPE, 'delete'),
        );
    }
    
    private function _getRoles()
    {
        return array(
            Enum_Acl_Role::GUEST => array(
                    Enum_Acl_Role::GUEST            =>  true,
                    Enum_Acl_Role::USER             =>  true,
                    Enum_Acl_Role::MODERATOR        =>  true,
                    Enum_Acl_Role::ADMINISTRATOR    =>  true
                ),
            Enum_Acl_Role::USER => array(
                Enum_Acl_Role::GUEST            =>  false,
                Enum_Acl_Role::USER             =>  true,
                Enum_Acl_Role::MODERATOR        =>  true,
                Enum_Acl_Role::ADMINISTRATOR    =>  true
            ),
            Enum_Acl_Role::MODERATOR => array(
                Enum_Acl_Role::GUEST            =>  false,
                Enum_Acl_Role::USER             =>  false,
                Enum_Acl_Role::MODERATOR        =>  true,
                Enum_Acl_Role::ADMINISTRATOR    =>  true
            ),
            Enum_Acl_Role::ADMINISTRATOR => array(
                Enum_Acl_Role::GUEST            =>  false,
                Enum_Acl_Role::USER             =>  false,
                Enum_Acl_Role::MODERATOR        =>  false,
                Enum_Acl_Role::ADMINISTRATOR    =>  true
            )
        );
    }
}
