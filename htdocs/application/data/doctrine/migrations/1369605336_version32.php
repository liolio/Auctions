<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version32 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->createForeignKey('delivery_form', 'delivery_form_transaction_id_transaction_id', array(
             'name' => 'delivery_form_transaction_id_transaction_id',
             'local' => 'transaction_id',
             'foreign' => 'id',
             'foreignTable' => 'transaction',
             'onUpdate' => '',
             'onDelete' => 'RESTRICT',
             ));
        $this->createForeignKey('delivery_form', 'delivery_form_address_id_address_id', array(
             'name' => 'delivery_form_address_id_address_id',
             'local' => 'address_id',
             'foreign' => 'id',
             'foreignTable' => 'address',
             'onUpdate' => '',
             'onDelete' => 'SET NULL',
             ));
        $this->createForeignKey('delivery_form', 'delivery_form_delivery_id_delivery_id', array(
             'name' => 'delivery_form_delivery_id_delivery_id',
             'local' => 'delivery_id',
             'foreign' => 'id',
             'foreignTable' => 'delivery',
             'onUpdate' => '',
             'onDelete' => 'RESTRICT',
             ));
        $this->addIndex('delivery_form', 'delivery_form_transaction_id', array(
             'fields' => 
             array(
              0 => 'transaction_id',
             ),
             ));
        $this->addIndex('delivery_form', 'delivery_form_address_id', array(
             'fields' => 
             array(
              0 => 'address_id',
             ),
             ));
        $this->addIndex('delivery_form', 'delivery_form_delivery_id', array(
             'fields' => 
             array(
              0 => 'delivery_id',
             ),
             ));
    }

    public function down()
    {
        $this->dropForeignKey('delivery_form', 'delivery_form_transaction_id_transaction_id');
        $this->dropForeignKey('delivery_form', 'delivery_form_address_id_address_id');
        $this->dropForeignKey('delivery_form', 'delivery_form_delivery_id_delivery_id');
        $this->removeIndex('delivery_form', 'delivery_form_transaction_id', array(
             'fields' => 
             array(
              0 => 'transaction_id',
             ),
             ));
        $this->removeIndex('delivery_form', 'delivery_form_address_id', array(
             'fields' => 
             array(
              0 => 'address_id',
             ),
             ));
        $this->removeIndex('delivery_form', 'delivery_form_delivery_id', array(
             'fields' => 
             array(
              0 => 'delivery_id',
             ),
             ));
    }
}