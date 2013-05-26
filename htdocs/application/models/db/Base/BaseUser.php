<?php

/**
 * BaseUser
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $login
 * @property string $password
 * @property integer $salt
 * @property string $secret_code
 * @property string $email
 * @property boolean $active
 * @property timestamp $last_login
 * @property enum $role
 * @property Doctrine_Collection $Addresses
 * @property Doctrine_Collection $Auctions
 * @property Doctrine_Collection $BankingInformations
 * @property Doctrine_Collection $Files
 * @property Doctrine_Collection $Transactions
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7691 2011-02-04 15:43:29Z jwage $
 */
abstract class BaseUser extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('user');
        $this->hasColumn('id', 'integer', 5, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             'unsigned' => true,
             'length' => '5',
             ));
        $this->hasColumn('login', 'string', 100, array(
             'type' => 'string',
             'notnull' => true,
             'length' => '100',
             ));
        $this->hasColumn('password', 'string', 40, array(
             'type' => 'string',
             'fixed' => 1,
             'notnull' => true,
             'length' => '40',
             ));
        $this->hasColumn('salt', 'integer', 2, array(
             'type' => 'integer',
             'unsigned' => true,
             'notnull' => true,
             'length' => '2',
             ));
        $this->hasColumn('secret_code', 'string', 40, array(
             'type' => 'string',
             'fixed' => 1,
             'length' => '40',
             ));
        $this->hasColumn('email', 'string', 100, array(
             'type' => 'string',
             'notnull' => true,
             'length' => '100',
             ));
        $this->hasColumn('active', 'boolean', null, array(
             'type' => 'boolean',
             'notnull' => true,
             'default' => false,
             ));
        $this->hasColumn('last_login', 'timestamp', null, array(
             'type' => 'timestamp',
             ));
        $this->hasColumn('role', 'enum', null, array(
             'type' => 'enum',
             'values' => 
             array(
              0 => 'user',
              1 => 'moderator',
              2 => 'administrator',
             ),
             'notnull' => true,
             'default' => 'user',
             ));


        $this->index('login_unique', array(
             'fields' => 
             array(
              0 => 'login',
             ),
             'type' => 'unique',
             ));
        $this->index('secret_code_unique', array(
             'fields' => 
             array(
              0 => 'secret_code',
             ),
             'type' => 'unique',
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('Address as Addresses', array(
             'local' => 'id',
             'foreign' => 'user_id'));

        $this->hasMany('Auction as Auctions', array(
             'local' => 'id',
             'foreign' => 'user_id'));

        $this->hasMany('BankingInformation as BankingInformations', array(
             'local' => 'id',
             'foreign' => 'user_id'));

        $this->hasMany('File as Files', array(
             'local' => 'id',
             'foreign' => 'user_id'));

        $this->hasMany('Transaction as Transactions', array(
             'local' => 'id',
             'foreign' => 'user_id'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}