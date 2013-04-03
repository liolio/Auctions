<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version16 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->createForeignKey('auction', 'auction_user_id_user_id', array(
             'name' => 'auction_user_id_user_id',
             'local' => 'user_id',
             'foreign' => 'id',
             'foreignTable' => 'user',
             'onUpdate' => '',
             'onDelete' => 'CASCADE',
             ));
        $this->createForeignKey('auction', 'auction_category_id_category_id', array(
             'name' => 'auction_category_id_category_id',
             'local' => 'category_id',
             'foreign' => 'id',
             'foreignTable' => 'category',
             'onUpdate' => '',
             'onDelete' => 'RESTRICT',
             ));
        $this->createForeignKey('auction_transaction_type', 'auction_transaction_type_transaction_type_id_transaction_type_id', array(
             'name' => 'auction_transaction_type_transaction_type_id_transaction_type_id',
             'local' => 'transaction_type_id',
             'foreign' => 'id',
             'foreignTable' => 'transaction_type',
             'onUpdate' => '',
             'onDelete' => 'RESTRICT',
             ));
        $this->createForeignKey('auction_transaction_type', 'auction_transaction_type_auction_id_auction_id', array(
             'name' => 'auction_transaction_type_auction_id_auction_id',
             'local' => 'auction_id',
             'foreign' => 'id',
             'foreignTable' => 'auction',
             'onUpdate' => '',
             'onDelete' => 'CASCADE',
             ));
        $this->addIndex('auction', 'auction_user_id', array(
             'fields' => 
             array(
              0 => 'user_id',
             ),
             ));
        $this->addIndex('auction', 'auction_category_id', array(
             'fields' => 
             array(
              0 => 'category_id',
             ),
             ));
        $this->addIndex('auction_transaction_type', 'auction_transaction_type_transaction_type_id', array(
             'fields' => 
             array(
              0 => 'transaction_type_id',
             ),
             ));
        $this->addIndex('auction_transaction_type', 'auction_transaction_type_auction_id', array(
             'fields' => 
             array(
              0 => 'auction_id',
             ),
             ));
    }

    public function down()
    {
        $this->dropForeignKey('auction', 'auction_user_id_user_id');
        $this->dropForeignKey('auction', 'auction_category_id_category_id');
        $this->dropForeignKey('auction_transaction_type', 'auction_transaction_type_transaction_type_id_transaction_type_id');
        $this->dropForeignKey('auction_transaction_type', 'auction_transaction_type_auction_id_auction_id');
        $this->removeIndex('auction', 'auction_user_id', array(
             'fields' => 
             array(
              0 => 'user_id',
             ),
             ));
        $this->removeIndex('auction', 'auction_category_id', array(
             'fields' => 
             array(
              0 => 'category_id',
             ),
             ));
        $this->removeIndex('auction_transaction_type', 'auction_transaction_type_transaction_type_id', array(
             'fields' => 
             array(
              0 => 'transaction_type_id',
             ),
             ));
        $this->removeIndex('auction_transaction_type', 'auction_transaction_type_auction_id', array(
             'fields' => 
             array(
              0 => 'auction_id',
             ),
             ));
    }
}