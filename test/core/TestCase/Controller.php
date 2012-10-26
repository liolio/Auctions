<?php
/**
 * @class TestCase_Controller
 */
class TestCase_Controller extends Zend_Test_PHPUnit_ControllerTestCase
{
    
    protected $backupGlobals = false;
    
    /**
     * @var boolean
     */
    private $_logInAdminUser = true;
    
    /**
     * @var TestCase_Facade
     */
    private $_facade;
    
    /**
     * Constructs a test case with the given name.
     *
     * @param  string $name
     * @param  array  $data
     * @param  string $dataName
     */
    public function  __construct($name = NULL, array $data = array(), $dataName = '')
    {
        $this->_getFacade()->setLoadFixtures();
        
        parent::__construct($name, $data, $dataName);
    }
    
    /**
     * Set up MVC app
     *
     * Calls {@link bootstrap()} by default
     *
     * @return void
     */
    protected function setUp()
    {
        $this->_getFacade()->reloadDatabase();
        parent::setUp();
        
        $this->_logInAdminUser();

        $this->assertEquals(0, Doctrine_Manager::connection()->getTransactionLevel());
    }
    
    /**
     * 
     * @return Zend_Translate
     */
    protected function _getTranslator()
    {
        return $this->_getFacade()->getTranslator();
    }
    
    /**
     * User won't be logged in.
     */
    protected function _disableLoggingInAdminUser()
    {
        $this->_logInAdminUser = false;
    }
    
    /**
     * Log in admin user.
     */
    protected function _logInAdminUser()
    {
        if ($this->_logInAdminUser)
        {
            $authAdapter = new Auth_Adapter('admin', 'admin');
            Zend_Auth::getInstance()->authenticate($authAdapter);
            $this->assertTrue(Zend_Auth::getInstance()->hasIdentity());
        }
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
