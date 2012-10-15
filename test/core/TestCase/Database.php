<?php
/**
 * @class TestCase_Database
 */
class TestCase_Database extends PHPUnit_Framework_TestCase
{
    
    protected $backupGlobals = false;
    
    /**
     * @var TestCase_Facade
     */
    private $_facade;
    
    /**
     * Constructs a test case with the given name.
     * @overrides
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
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     * @overrides
     *
     */
    protected function setUp()
    {
        $this->_getFacade()->reloadDatabase();
        parent::setUp();

        $this->assertEquals(0, Doctrine_Manager::connection()->getTransactionLevel());
    }
    
    /**
     * Fixtures won't be loaded.
     */
    protected function _disableFixturesLoading()
    {
        $this->_getFacade()->setLoadFixtures(false);
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
