<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version13 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->createTable('currency', array(
             'id' => 
             array(
              'type' => 'integer',
              'primary' => '1',
              'autoincrement' => '1',
              'unsigned' => '1',
              'length' => '5',
             ),
             'name' => 
             array(
              'type' => 'string',
              'notnull' => '1',
              'length' => '100',
             ),
             ), array(
             'primary' => 
             array(
              0 => 'id',
             ),
             'collate' => 'utf8_unicode_ci',
             'charset' => 'utf8',
             ));
        $this->removeColumn('banking_information', 'currency');
        $this->addColumn('banking_information', 'currency_id', 'integer', '5', array(
             'unsigned' => '1',
             'notnull' => '1',
             ));
    }

    public function down()
    {
        $this->dropTable('currency');
        $this->addColumn('banking_information', 'currency', 'string', '100', array(
             'notnull' => '1',
             ));
        $this->removeColumn('banking_information', 'currency_id');
    }
}