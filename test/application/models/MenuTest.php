<?php
/**
 * @class MenuTest
 */
class MenuTest extends TestCase_Controller
{
    
    /**
     * @test
     * @dataProvider dataProvider
     */
    public function validate($role, $expectedElements)
    {
        Auth_User::getInstance()->getUser()->role = $role;
        $menu = new Menu();
        $menu
            ->addElement(
                'element1',
                Menu_Element::create('login', 'login', 'loginDescription')
                    ->enableFor(Enum_Acl_Role::ADMINISTRATOR)
                    ->enableFor(Enum_Acl_Role::MODERATOR)
            )
            ->addElement(
                'element2',
                Menu_Element::create('index', 'index', 'indexDescription')
                    ->enableFor(Enum_Acl_Role::MODERATOR)
                    ->enableFor(Enum_Acl_Role::GUEST)
            );
        
        $elements = array();
        foreach ($menu as $menuElement)
            $elements[] = $menuElement->getRoute();
        
        $this->assertEquals($expectedElements, $elements);
    }
    
    public function dataProvider()
    {
        return array(
            array(Enum_Acl_Role::ADMINISTRATOR, array('login')),
            array(Enum_Acl_Role::GUEST, array('index')),
            array(Enum_Acl_Role::MODERATOR, array('login', 'index')),
            array(Enum_Acl_Role::USER, array())
        );
    }
}
