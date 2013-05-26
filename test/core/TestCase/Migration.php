<?php
/**
 * @class TestCase_Migration
 */
abstract class TestCase_Migration extends PHPUnit_Framework_TestCase
{
    
    const COLUMN_FIELD = 'Field';
    const COLUMN_TYPE = 'Type';
    const COLUMN_NULL = 'Null';
    const COLUMN_KEY = 'Key';
    const COLUMN_DEFAULT = 'Default';
    const COLUMN_EXTRA = 'Extra';
    
    const FOREIGN_KEY_TABLE_NAME = 'TABLE_NAME';
    const FOREIGN_KEY_COLUMN_NAME = 'COLUMN_NAME';
    const FOREIGN_KEY_CONSTRAINT_NAME = 'CONSTRAINT_NAME';
    const FOREIGN_KEY_REFERENCED_TABLE_NAME = 'REFERENCED_TABLE_NAME';
    const FOREIGN_KEY_REFERENCED_COLUMN_NAME = 'REFERENCED_COLUMN_NAME';
    
    const TABLES_IN_AUCTIONS_TEST = 'Tables_in_auctions_test';

    protected $backupGlobals = false;
    
    /**
     * @var TestCase_Facade
     */
    private $_facade;
    
    abstract protected function _getMigrationVersion();
    
    abstract protected function _loadData();
    
    protected function setUp()
    {
        parent::setUp();
        
        Database_Reloader::getInstance()->dropTables();
        
        $this->assertEquals(0, Doctrine_Manager::connection()->getTransactionLevel());
        
        if ($this->_getMigrationVersion() > 1)
            $this->_migrate($this->_getMigrationVersion() - 1);
        
        $this->_loadData();
        
        $this->_migrate($this->_getMigrationVersion());
    }
    
    protected function _executeQuery($query)
    {
        $statement = Doctrine_Manager::connection()->getDbh()->prepare($query);
        $statement->execute();
        
        return $statement->fetchAll();
    }
    
    protected function _assertTables(array $expectedTablesConfig)
    {
        $tablesData = $this->_getTablesData();
        
        for ($i = 0; $i < count($expectedTablesConfig); $i++)
            $this->assertEquals($expectedTablesConfig[$i][self::TABLES_IN_AUCTIONS_TEST], $tablesData[$i][self::TABLES_IN_AUCTIONS_TEST]);
    }
    
    protected function _assertColumns($tableName, array $expectedColumnsConfig)
    {
        $columnsData = $this->_getColumnsData($tableName);
        
        $this->assertEquals(count($expectedColumnsConfig), count($columnsData));
        for ($i = 0; $i < count($columnsData); $i++)
        {
            $this->assertEquals($expectedColumnsConfig[$i][self::COLUMN_FIELD], $columnsData[$i][self::COLUMN_FIELD], "Column " . $i);
            
            $this->_assertColumnOption(self::COLUMN_TYPE, $expectedColumnsConfig[$i], $columnsData[$i], "Column " . $i);
            $this->_assertColumnOption(self::COLUMN_NULL, $expectedColumnsConfig[$i], $columnsData[$i], "Column " . $i);
            $this->_assertColumnOption(self::COLUMN_KEY, $expectedColumnsConfig[$i], $columnsData[$i], "Column " . $i);
            $this->_assertColumnOption(self::COLUMN_DEFAULT, $expectedColumnsConfig[$i], $columnsData[$i], "Column " . $i);
            $this->_assertColumnOption(self::COLUMN_EXTRA, $expectedColumnsConfig[$i], $columnsData[$i], "Column " . $i);
        }
    }
    
    private function _assertColumnOption($optionName, array $expectedColumnConfig, array $columnData, $message)
    {
        if (array_key_exists($optionName, $expectedColumnConfig))
            $this->assertEquals($expectedColumnConfig[$optionName], $columnData[$optionName], $message);
    }
    
    private function _migrate($versonNumber)
    {
        $migration = new Doctrine_Migration(APPLICATION_PATH . "/data/doctrine/migrations");
        $migration->migrate($versonNumber);
    }
    
    private function _getTablesData()
    {
        return $this->_executeQuery('SHOW TABLES');
    }
    
    private function _getColumnsData($tableName)
    {
        return $this->_executeQuery('SHOW COLUMNS FROM ' . $tableName);
    }
    
    protected function _getForeignKeysData($tableName)
    {
        return $this->_executeQuery("SELECT TABLE_NAME, " .
            "COLUMN_NAME,CONSTRAINT_NAME, REFERENCED_TABLE_NAME, REFERENCED_COLUMN_NAME " .
            "FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE WHERE REFERENCED_TABLE_NAME = '" . $tableName . "' AND " .
            "TABLE_SCHEMA = 'auctions_test'");
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
