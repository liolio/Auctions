<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version6 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->createForeignKey('address', 'address_user_id_user_id', array(
             'name' => 'address_user_id_user_id',
             'local' => 'user_id',
             'foreign' => 'id',
             'foreignTable' => 'user',
             'onUpdate' => '',
             'onDelete' => 'CASCADE',
             ));
        $this->addIndex('address', 'address_user_id', array(
             'fields' => 
             array(
              0 => 'user_id',
             ),
             ));
        $this->addIndex('user', 'login_unique', array(
             'fields' => 
             array(
              0 => 'login',
             ),
             'type' => 'unique',
             ));
        $this->addIndex('user', 'secret_code_unique', array(
             'fields' => 
             array(
              0 => 'secret_code',
             ),
             'type' => 'unique',
             ));
    }

    public function down()
    {
        $this->dropForeignKey('address', 'address_user_id_user_id');
        $this->removeIndex('address', 'address_user_id', array(
             'fields' => 
             array(
              0 => 'user_id',
             ),
             ));
        $this->removeIndex('user', 'login_unique', array(
             'fields' => 
             array(
              0 => 'login',
             ),
             'type' => 'unique',
             ));
        $this->removeIndex('user', 'secret_code_unique', array(
             'fields' => 
             array(
              0 => 'secret_code',
             ),
             'type' => 'unique',
             ));
    }
}