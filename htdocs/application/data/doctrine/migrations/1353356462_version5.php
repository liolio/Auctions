<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version5 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->createTable('address', array(
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
             'surname' => 
             array(
              'type' => 'string',
              'notnull' => '',
              'length' => '100',
             ),
             'street' => 
             array(
              'type' => 'string',
              'notnull' => '1',
              'length' => '100',
             ),
             'postal_code' => 
             array(
              'type' => 'string',
              'notnull' => '1',
              'length' => '10',
             ),
             'city' => 
             array(
              'type' => 'string',
              'notnull' => '1',
              'length' => '100',
             ),
             'province' => 
             array(
              'type' => 'string',
              'notnull' => '1',
              'length' => '100',
             ),
             'country' => 
             array(
              'type' => 'string',
              'notnull' => '1',
              'length' => '100',
             ),
             'phone_number' => 
             array(
              'type' => 'string',
              'notnull' => '1',
              'length' => '15',
             ),
             'user_id' => 
             array(
              'type' => 'integer',
              'unsigned' => '1',
              'notnull' => '1',
              'length' => '5',
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
        $this->dropTable('address');
    }
}