<?php
/**
 * @class Menu_ElementTest
 */
class Menu_ElementTest extends TestCase_Controller
{

    /**
     * @var Menu_Element
     */
    private $_menuElement;
    
    protected function setUp()
    {
        parent::setUp();
        $this->_menuElement = Menu_Element::create("index", "index", "indexDescription")
            ->enableFor(Enum_Acl_Role::ADMINISTRATOR);
    }

    /**
     * @test
     * @dataProvider activeDataProvider
     */
    public function active($route, $active)
    {
        $this->dispatch($route);
        $this->assertEquals($active, $this->_menuElement->isActive());
    }
    
    public function activeDataProvider()
    {
        return array(
            array('', true),
            array('index', false)
        );
    }
    
    /**
     * @test
     * @dataProvider isEnabledForDataProvider
     */
    public function isEnabledFor($role, $enabled)
    {
        $this->assertEquals($enabled, $this->_menuElement->isEnabledFor($role));
    }
    
    public function isEnabledForDataProvider()
    {
        return array(
            array(Enum_Acl_Role::ADMINISTRATOR, true),
            array(Enum_Acl_Role::GUEST, false),
            array(Enum_Acl_Role::MODERATOR, false),
            array(Enum_Acl_Role::USER, false)
        );
    }
    
    /**
     * @test
     */
    public function isEnabledForNonExistingRole()
    {
        try {
            $this->_menuElement->isEnabledFor("NON_EXISTING");
            $this->fail("InvalidArgumentException expected, nothing has been thrown");
        } catch (InvalidArgumentException $ex) {
            $this->assertEquals('Role "NON_EXISTING" doesn\'t exist.', $ex->getMessage());
        }
    }
    
    /**
     * @test
     */
    public function enabledForNonExistingRole()
    {
        try {
            $this->_menuElement->enableFor("NON_EXISTING");
            $this->fail("InvalidArgumentException expected, nothing has been thrown");
        } catch (InvalidArgumentException $ex) {
            $this->assertEquals('Role "NON_EXISTING" doesn\'t exist.', $ex->getMessage());
        }
    }
}
