<?php
/**
 * @class Migration_Version3Test
 */
class Migration_Version3Test extends TestCase_Migration
{
    
    /**
     * @test
     */
    public function migrate()
    {
        $this->_assertTables(array(
            array(self::TABLES_IN_AUCTIONS_TEST    =>  'log'),
            array(self::TABLES_IN_AUCTIONS_TEST    =>  'migration_version'),
            array(self::TABLES_IN_AUCTIONS_TEST    =>  'notification'),
            array(self::TABLES_IN_AUCTIONS_TEST    =>  'user'),
        ));
        
        $this->_assertColumns("log", TestCase_Migration_TableStructure_Log::getStructure($this->_getMigrationVersion()));
        $this->_assertColumns('migration_version', TestCase_Migration_TableStructure_MigrationVersion::getStructure($this->_getMigrationVersion()));
        $this->_assertColumns('notification', TestCase_Migration_TableStructure_Notification::getStructure($this->_getMigrationVersion()));
        $this->_assertColumns('user', TestCase_Migration_TableStructure_User::getStructure($this->_getMigrationVersion()));
    }

    protected function _getMigrationVersion()
    {
        return 3;
    }

    protected function _loadData()
    {
        
    }

}
