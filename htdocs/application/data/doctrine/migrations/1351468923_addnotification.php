<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Addnotification extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->createTable('notification', array(
             'id' => 
             array(
              'type' => 'integer',
              'primary' => true,
              'autoincrement' => true,
              'unsigned' => true,
              'length' => 5,
             ),
             'related_object_id' => 
             array(
              'type' => 'integer',
              'notnull' => true,
              'length' => 5,
             ),
             'type' => 
             array(
              'type' => 'enum',
              'values' => 
              array(
              0 => 'user_registration',
              ),
              'length' => NULL,
             ),
             'created_at' => 
             array(
              'notnull' => true,
              'type' => 'timestamp',
              'length' => 25,
             ),
             'updated_at' => 
             array(
              'notnull' => true,
              'type' => 'timestamp',
              'length' => 25,
             ),
             ), array(
             'indexes' => 
             array(
             ),
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
        $this->dropTable('notification');
    }
}