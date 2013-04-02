<?php
/**
 * @class Database_Reloader
 */
class Database_Reloader
{
    /**
     * @var Database_Reloader
     */
    private static $_instance;

    /**
     * @var PDO
     */
    private $_databaseHandler;

    private function  __construct()
    {
        $this->_databaseHandler = Doctrine_Manager::getInstance()->getCurrentConnection()->getDbh();
    }
    
    /**
     *
     * @return Database_Reloader
     */
    public static function getInstance()
    {
        if (is_null(self::$_instance))
            self::$_instance = new self;

        return self::$_instance;
    }

    /**
     * Clears database.
     *
     * @return Database_Reloader
     */
    public function clearDatabase()
    {
        $this->_setForeignKeyChecking(false);

        foreach ($this->_getTables() as $table)
            $this->_executeQuery('TRUNCATE ' . $table['TABLE_NAME']);

        $this->_setForeignKeyChecking();

        return $this;
    }
    
    public function dropTables()
    {
        $this->_setForeignKeyChecking(false);
        
        foreach ($this->_getTables() as $table)
            $this->_executeQuery('DROP TABLE ' . $table['TABLE_NAME']);
        
        $this->_setForeignKeyChecking();
        
        return $this;
    }

    /**
     *
     * @param string $statement
     * @return boolean
     */
    private function _executeQuery($statement)
    {
        return $this->_databaseHandler
                ->prepare($statement)
                ->execute();
    }

    /**
     * Loads fixtures.
     * 
     * @return Database_Reloader
     */
    public function loadFixtures()
    {
        $this->_setForeignKeyChecking(false);

        $fixtures = explode(';', file_get_contents(Zend_Registry::get('config')->doctrine->sql_path . '/fixtures.sql'));
        foreach ($fixtures as $fixture)
        {
            $fixture = str_replace("\\", "", trim($fixture));

            if (empty($fixture) === false)
                $this->_executeQuery($fixture);
        }

        $this->_setForeignKeyChecking();

        return $this;
    }

    /**
     *
     * @param boolean $enable
     * @return Database_Reloader
     */
    private function _setForeignKeyChecking($enable = true)
    {
        $enable = $enable ? 1 : 0;
        $this->_executeQuery('SET foreign_key_checks = ' . $enable);
        
        return $this;
    }

    /**
     * 
     * @return array
     */
    private function _getTables()
    {
        $sql =
            'SELECT TABLE_NAME, TABLE_SCHEMA '.
            'FROM INFORMATION_SCHEMA.TABLES '.
            "WHERE TABLE_SCHEMA = '" . Zend_Registry::get('config')->doctrine->database_name . "' ".
            "AND TABLE_TYPE = 'BASE TABLE'";

        $statement = $this->_databaseHandler->prepare($sql);
        $statement->execute();

        return $statement->fetchAll();
    }
}
