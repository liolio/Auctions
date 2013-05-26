<?php
/**
 * @class Session_LastVisitedTest
 */
class Session_LastVisitedTest extends TestCase_Controller
{
    
    /**
     * @test
     */
    public function save()
    {
        $url = "asd/qwe/123";
        
        Session_LastVisited::save($url);
        
        $nameSpace = new Zend_Session_Namespace(Session_LastVisited::NAME_SPACE);
        $this->assertEquals($url, $nameSpace->last);
    }
    
    /**
     * @test
     */
    public function getLastVisited()
    {
        $url = "asd/qwe/123";
        
        $nameSpace = new Zend_Session_Namespace(Session_LastVisited::NAME_SPACE);
        $nameSpace->last = $url;
        
        $this->assertEquals($url, Session_LastVisited::getLastVisited());
    }
}
