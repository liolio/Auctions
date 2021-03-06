<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version33 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->createTable('news', array(
             'id' => 
             array(
              'type' => 'integer',
              'primary' => '1',
              'autoincrement' => '1',
              'unsigned' => '1',
              'length' => '5',
             ),
             'title' => 
             array(
              'type' => 'string',
              'notnull' => '1',
              'length' => '100',
             ),
             'description' => 
             array(
              'type' => 'string',
              'notnull' => '1',
              'length' => '1000',
             ),
             'user_id' => 
             array(
              'type' => 'integer',
              'unsigned' => '1',
              'notnull' => '1',
              'length' => '5',
             ),
             'created_at' => 
             array(
              'notnull' => '1',
              'type' => 'timestamp',
              'length' => '25',
             ),
             'updated_at' => 
             array(
              'notnull' => '1',
              'type' => 'timestamp',
              'length' => '25',
             ),
             ), array(
             'primary' => 
             array(
              0 => 'id',
             ),
             'collate' => 'utf8_unicode_ci',
             'charset' => 'utf8',
             ));
    }

    public function down()
    {
        $this->dropTable('news');
    }
}