<?php
/**
 * @class Migration_Version1Test
 */
class Migration_Version1Test extends TestCase_Migration
{

    /**
     * @test
     */
    public function migrate()
    {
        $this->_assertTables(array(
            array(self::TABLES_IN_AUCTIONS_TEST    =>  'log'),
            array(self::TABLES_IN_AUCTIONS_TEST    =>  'migration_version')
        ));
        
        $this->_assertColumns("log", TestCase_Migration_TableStructure_Log::getStructure($this->_getMigrationVersion()));
        $this->_assertColumns('migration_version', TestCase_Migration_TableStructure_MigrationVersion::getStructure($this->_getMigrationVersion()));
    }

    protected function _getMigrationVersion()
    {
        return 1;
    }

    protected function _loadData()
    {
        
    }
    
}
