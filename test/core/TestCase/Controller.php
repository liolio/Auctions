<?php
/**
 * @class TestCase_Controller
 */
abstract class TestCase_Controller extends Zend_Test_PHPUnit_ControllerTestCase
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
        $application = new Zend_Application(APPLICATION_ENV, APPLICATION_PATH . '/configs/application.ini');
        $this->bootstrap = array($application->getBootstrap(), 'bootstrap');
        
        $this->_getFacade()->reloadDatabase();
        parent::setUp();
        
        Zend_Auth::getInstance()->clearIdentity();
        if ($this->_logInAdminUser)
            $this->_logInAdminUser();

        $this->assertEquals(0, Doctrine_Manager::connection()->getTransactionLevel());
    }
    
    protected function _loadFixture($path)
    {
        Fixture_Loader::create($path);
    }
    
    protected function _loadFixtures(array $paths)
    {
        Fixture_Loader::createAll($paths);
    }
    
    /**
     * Sets request data.
     * 
     * @param array $data
     * @param string $requestMethod [optional] Default set to POST
     */
    protected function _setRequest(array $data, $requestMethod = 'POST')
    {
        $this->_request
            ->clearParams()
            ->setPost($data)
            ->setMethod($requestMethod);
    }
    
    protected function _assertDispatch($controller, $action, $module = 'auctions')
    {
        $this->assertModule($module);
        $this->assertController($controller);
        $this->assertAction($action);
    }
    
    protected function _assertAclDeny()
    {
        $this->assertModule('auctions');
        $this->assertController('index');
        $this->assertAction('index');
    }
    
    protected function _assertTime($first, $second, $allowedTimeDiff = 2)
    {
        $timeDiff = $this->_getFacade()->getTimeDiff($first, $second);
        $this->assertTrue($timeDiff <= $allowedTimeDiff);
    }
    
    /**
     * 
     * @return Zend_Translate
     */
    protected function _getTranslator()
    {
        return Helper::getTranslator();
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
        $authAdapter = new Auth_Adapter('admin', 'admin');
        Zend_Auth::getInstance()->authenticate($authAdapter);
        $this->assertTrue(Zend_Auth::getInstance()->hasIdentity());
    }
    
    /**
     * Log in admin user.
     */
    protected function _logInUser($username, $password)
    {
        $authAdapter = new Auth_Adapter($username, $password);
        Zend_Auth::getInstance()->authenticate($authAdapter);
        $this->assertTrue(Zend_Auth::getInstance()->hasIdentity());
    }
    
    /**
     * Returns logged user. If no user is logged returns false.
     * 
     * @return User|false
     */
    protected function _getLoggedUser()
    {
        return Zend_Auth::getInstance()->hasIdentity() ? UserTable::getInstance()->findOneBy('login', 'admin') : false;
    }
    
    protected function _assertRedirection($url)
    {
        $this->assertRedirect();
        $headers = $this->getResponse()->getHeaders();
        $this->assertEquals(
                array(
                    array(
                        "name"      =>  "Location",
                        "value"     =>  $this->getFrontController()->getBaseUrl() . '/' . $url,
                        "replace"   =>  true
                    )
                ),
                $headers
        );
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
