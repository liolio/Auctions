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
        $menu = new Menu($role);
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
    
    /**
     * @test
     */
    public function createForNonExistingRole()
    {
        try {
            new Menu("NON_EXISTING");
            $this->fail("InvalidArgumentException expected, nothing has been thrown");
        } catch (InvalidArgumentException $ex) {
            $this->assertEquals('Role "NON_EXISTING" doesn\'t exist.', $ex->getMessage());
        }
    }
}
