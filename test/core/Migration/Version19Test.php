<?php
/**
 * @class Migration_Version19Test
 */
class Migration_Version19Test extends TestCase_Migration
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
        return 19;
    }

    protected function _loadData()
    {
        $user = new User();
        $user->active = 1;
        $user->email = "a@a.pl";
        $user->login = 'a';
        $user->password = str_repeat('a', 40);
        $user->role = 'user';
        $user->salt = '12345';
        $user->save();
        
        $category = new Category();
        $category->name = 'a';
        $category->description = 'a';
        $category->save();
        
        $auction = new Auction();
        $auction->category_id = 1;
        $auction->description = 'a';
        $auction->duration = 7;
        $auction->number_of_items = 1;
        $auction->start_time = "2012-05-05 22:22:22";
        $auction->title = 'a';
        $auction->user_id = 1;
        $auction->save();
        
        $this->assertEquals(0, AuctionTable::getInstance()->find(1)->currency_id);
    }
    
    private function _assertData()
    {
        $this->assertEquals(1, AuctionTable::getInstance()->find(1)->currency_id);
    }

}
