<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version18 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->addColumn('auction', 'currency_id', 'integer', '5', array(
             'unsigned' => '1',
             'notnull' => '1',
             ));
    }

    public function down()
    {
        $this->removeColumn('auction', 'currency_id');
    }
}