<?php
/**
 * @class Session_DialogWindowTest
 */
class Session_DialogWindowTest extends TestCase_Controller
{
    
    /**
     * @test
     */
    public function save()
    {
        $url = "asd/qwe/123";
        
        Session_DialogWindow::save($url);
        
        $nameSpace = new Zend_Session_Namespace(Session_DialogWindow::NAME_SPACE);
        $this->assertEquals($url, $nameSpace->last);
    }
    
    /**
     * @test
     */
    public function getValue()
    {
        $url = "asd/qwe/123";
        
        $nameSpace = new Zend_Session_Namespace(Session_DialogWindow::NAME_SPACE);
        $nameSpace->last = $url;
        
        $this->assertEquals($url, Session_DialogWindow::getValue());
    }
}
