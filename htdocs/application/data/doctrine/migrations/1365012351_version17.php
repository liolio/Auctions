<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version17 extends Doctrine_Migration_Base
{
    public function up()
    {
        if ($this->_countTransactionTypes() === '0')
        {
            Doctrine_Manager::connection()->execute(
                "INSERT INTO transaction_type(id, name) VALUES" .
                "(1, 'BIDDING'), " .
                "(2, 'BUY_OUT')"
            );
        }
    }

    public function down()
    {
        
    }
    
    private function _countTransactionTypes()
    {
        $statement = Doctrine_Manager::connection()->getDbh()->prepare("SELECT count(id) as count FROM transaction_type");
        $statement->execute();
        
        $result = $statement->fetchAll();
        return $result[0]['count'];
    }
}