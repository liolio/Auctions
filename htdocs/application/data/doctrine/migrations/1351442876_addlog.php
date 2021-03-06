<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Addlog extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->createTable('log', array(
             'id' => 
             array(
              'type' => 'integer',
              'primary' => true,
              'unsigned' => true,
              'autoincrement' => true,
              'length' => 5,
             ),
             'timestamp' => 
             array(
              'type' => 'datetime',
              'notnull' => true,
              'length' => NULL,
             ),
             'priority_name' => 
             array(
              'type' => 'string',
              'notnull' => true,
              'length' => 10,
             ),
             'priority' => 
             array(
              'type' => 'integer',
              'unsigned' => true,
              'notnull' => true,
              'length' => 1,
             ),
             'message' => 
             array(
              'type' => 'string',
              'notnull' => true,
              'length' => 1000,
             ),
             'identity' => 
             array(
              'type' => 'string',
              'notnull' => true,
              'length' => 40,
             ),
             'ip_address' => 
             array(
              'type' => 'string',
              'length' => 39,
             ),
             'url' => 
             array(
              'type' => 'string',
              'notnull' => true,
              'length' => 255,
             ),
             'stack_trace' => 
             array(
              'type' => 'text',
              'length' => NULL,
             ),
             'post' => 
             array(
              'type' => 'text',
              'length' => NULL,
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
        $this->dropTable('log');
    }
}