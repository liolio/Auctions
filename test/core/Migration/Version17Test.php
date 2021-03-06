<?php
/**
 * @class Migration_Version17Test
 */
class Migration_Version17Test extends TestCase_Migration
{
    
    /**
     * @test
     */
    public function migrate()
    {
        $this->_assertTables(array(
            array(self::TABLES_IN_AUCTIONS_TEST    =>  'address'),
            array(self::TABLES_IN_AUCTIONS_TEST    =>  'auction'),
            array(self::TABLES_IN_AUCTIONS_TEST    =>  'auction_transaction_type'),
            array(self::TABLES_IN_AUCTIONS_TEST    =>  'banking_information'),
            array(self::TABLES_IN_AUCTIONS_TEST    =>  'category'),
            array(self::TABLES_IN_AUCTIONS_TEST    =>  'currency'),
            array(self::TABLES_IN_AUCTIONS_TEST    =>  'log'),
            array(self::TABLES_IN_AUCTIONS_TEST    =>  'migration_version'),
            array(self::TABLES_IN_AUCTIONS_TEST    =>  'notification'),
            array(self::TABLES_IN_AUCTIONS_TEST    =>  'transaction_type'),
            array(self::TABLES_IN_AUCTIONS_TEST    =>  'user'),
        ));
        
        $this->_assertColumns("address", TestCase_Migration_TableStructure_Address::getStructure($this->_getMigrationVersion()));
        $this->_assertColumns("auction", TestCase_Migration_TableStructure_Auction::getStructure($this->_getMigrationVersion()));
        $this->_assertColumns("auction_transaction_type", TestCase_Migration_TableStructure_AuctionTransactionType::getStructure($this->_getMigrationVersion()));
        $this->_assertColumns("banking_information", TestCase_Migration_TableStructure_BankingInformation::getStructure($this->_getMigrationVersion()));
        $this->_assertColumns("category", TestCase_Migration_TableStructure_Category::getStructure($this->_getMigrationVersion()));
        $this->_assertColumns("currency", TestCase_Migration_TableStructure_Currency::getStructure($this->_getMigrationVersion()));
        $this->_assertColumns("log", TestCase_Migration_TableStructure_Log::getStructure($this->_getMigrationVersion()));
        $this->_assertColumns('migration_version', TestCase_Migration_TableStructure_MigrationVersion::getStructure($this->_getMigrationVersion()));
        $this->_assertColumns('notification', TestCase_Migration_TableStructure_Notification::getStructure($this->_getMigrationVersion()));
        $this->_assertColumns("transaction_type", TestCase_Migration_TableStructure_TransactionType::getStructure($this->_getMigrationVersion()));
        $this->_assertColumns('user', TestCase_Migration_TableStructure_User::getStructure($this->_getMigrationVersion()));
        
        $this->_assertData();
    }

    protected function _getMigrationVersion()
    {
        return 17;
    }

    protected function _loadData()
    {
        
    }
    
    private function _assertData()
    {
        $transactionTypes = TransactionTypeTable::getInstance()->findAll();
        $this->assertEquals(2, count($transactionTypes));
        
        $this->assertEquals(Enum_Db_TransactionType_Type::BIDDING, $transactionTypes->get(0)->name);
        $this->assertEquals(Enum_Db_TransactionType_Type::BUY_OUT, $transactionTypes->get(1)->name);
    }

}
