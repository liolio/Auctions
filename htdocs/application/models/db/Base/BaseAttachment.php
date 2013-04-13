<?php

/**
 * BaseAttachment
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $auction_id
 * @property integer $file_id
 * @property Auction $Auction
 * @property File $File
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7691 2011-02-04 15:43:29Z jwage $
 */
abstract class BaseAttachment extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('attachment');
        $this->hasColumn('id', 'integer', 5, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             'unsigned' => true,
             'length' => '5',
             ));
        $this->hasColumn('auction_id', 'integer', 5, array(
             'type' => 'integer',
             'unsigned' => true,
             'notnull' => true,
             'length' => '5',
             ));
        $this->hasColumn('file_id', 'integer', 5, array(
             'type' => 'integer',
             'unsigned' => true,
             'notnull' => true,
             'length' => '5',
             ));


        $this->index('attachment_unique', array(
             'fields' => 
             array(
              0 => 'auction_id',
              1 => 'file_id',
             ),
             'type' => 'unique',
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Auction', array(
             'local' => 'auction_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $this->hasOne('File', array(
             'local' => 'file_id',
             'foreign' => 'id',
             'onDelete' => 'RESTRICT'));
    }
}