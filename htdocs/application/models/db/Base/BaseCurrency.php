<?php

/**
 * BaseCurrency
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $name
 * @property Doctrine_Collection $Auctions
 * @property Doctrine_Collection $BankingInformations
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7691 2011-02-04 15:43:29Z jwage $
 */
abstract class BaseCurrency extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('currency');
        $this->hasColumn('id', 'integer', 5, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             'unsigned' => true,
             'length' => '5',
             ));
        $this->hasColumn('name', 'string', 100, array(
             'type' => 'string',
             'notnull' => true,
             'length' => '100',
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('Auction as Auctions', array(
             'local' => 'id',
             'foreign' => 'currency_id'));

        $this->hasMany('BankingInformation as BankingInformations', array(
             'local' => 'id',
             'foreign' => 'currency_id'));
    }
}