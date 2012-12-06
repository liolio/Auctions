<?php
/**
 * @class Controller_Front_RequestTest
 */
class Controller_Front_RequestTest extends TestCase_Controller
{
    
    /**
     * @test
     */
    public function getRole()
    {
        $this->assertEquals(Acl_RoleEnum::ADMINISTRATOR, Controller_Front_Request::getRole());
    }
    
    /**
     * @test
     */
    public function getResource()
    {
        $this->assertEquals('Module:Controller', Controller_Front_Request::getResource($this->_getRequest()));
    }
    
    /**
     * @test
     */
    public function getPrivilege()
    {
        $this->assertEquals('some-action', Controller_Front_Request::getPrivilege($this->_getRequest()));
    }
    
    private function _getRequest()
    {
        $request = new Zend_Controller_Request_Http();
        $request->setModuleName('module');
        $request->setControllerName('controller');
        $request->setActionName('some-action');
        
        return $request;
    }
}
