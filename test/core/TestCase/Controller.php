<?php
/**
 * @class TestCase_Controller
 */
class TestCase_Controller extends Zend_Test_PHPUnit_ControllerTestCase
{
    
    protected $backupGlobals = false;
    
    /**
     * @var TestCase_Facade
     */
    private $_facade;
    
    public function  __construct($name = NULL, array $data = array(), $dataName = '')
    {
        $this->_getFacade()->setLoadFixtures();
        
        parent::__construct($name, $data, $dataName);
    }
    
    /**
     * Set up MVC app
     * @overrides
     *
     * Calls {@link bootstrap()} by default
     *
     * @return void
     */
    protected function setUp()
    {
        $this->_getFacade()->reloadDatabase();
        parent::setUp();

        $this->assertEquals(0, Doctrine_Manager::connection()->getTransactionLevel());
    }
    
    /**
     * 
     * @return TestCase_Facade
     */
    private function _getFacade()
    {
        if (is_null($this->_facade))
            $this->_facade = new TestCase_Facade();
        
        return $this->_facade;
    }
}
