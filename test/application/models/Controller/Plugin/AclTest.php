<?php
/**
 * @class Controller_Plugin_AclTest
 */
class Controller_Plugin_AclTest extends TestCase_Controller
{
    
    /**
     * @test
     * @dataProvider dataProvider
     */
    public function preDispatch($actionName, $expectedControllerName, $expectedActionName, $dialogWindow)
    {
        $request = new Zend_Controller_Request_Http();
        $request->setModuleName('auctions');
        $request->setControllerName('auth');
        $request->setActionName($actionName);
        Zend_Controller_Front::getInstance()->setRequest($request);
        
        $aclPlugin = new Controller_Plugin_Acl();
        $aclPlugin->preDispatch($request);
        
        $this->assertEquals('auctions', $request->getModuleName());
        $this->assertEquals($expectedControllerName, $request->getControllerName());
        $this->assertEquals($expectedActionName, $request->getActionName());
        
        $this->assertEquals($dialogWindow, Session_DialogWindow::getValue());
    }
    
    public static function dataProvider()
    {
        return array(
            array('process', 'auth', 'process', ''),
            array('index', 'auth', 'index', ''),
            array('non_existing', 'index', 'index', ParamIdEnum::WINDOW_ACL_FAILURE),
        );
    }
}
