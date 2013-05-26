<?php
/**
 * @class TestCase_Migration_TableStructure_Log
 */
class TestCase_Migration_TableStructure_Log implements TestCase_Migration_TableStructure
{
    
    public static function getStructure($versionNumber)
    {
        if ($versionNumber < 1)
            throw new InvalidArgumentException($versionNumber . " not supported.");
        
        switch ($versionNumber)
        {
            default :
                return self::_getStructureFromVersion1();
        }
    }
    
    private static function _getStructureFromVersion1()
    {
        return array(
            array(
                TestCase_Migration::COLUMN_FIELD     =>  'id',
                TestCase_Migration::COLUMN_TYPE      =>  'bigint(20) unsigned',
                TestCase_Migration::COLUMN_NULL      =>  'NO',
                TestCase_Migration::COLUMN_KEY       =>  'PRI',
                TestCase_Migration::COLUMN_DEFAULT   =>  null,
                TestCase_Migration::COLUMN_EXTRA     =>  'auto_increment',
            ),
            array(
                TestCase_Migration::COLUMN_FIELD     =>  'timestamp',
                TestCase_Migration::COLUMN_TYPE      =>  'datetime',
                TestCase_Migration::COLUMN_NULL      =>  'NO',
                TestCase_Migration::COLUMN_KEY       =>  '',
                TestCase_Migration::COLUMN_DEFAULT   =>  null,
                TestCase_Migration::COLUMN_EXTRA     =>  '',
            ),
            array(
                TestCase_Migration::COLUMN_FIELD     =>  'priority_name',
                TestCase_Migration::COLUMN_TYPE      =>  'varchar(10)',
                TestCase_Migration::COLUMN_NULL      =>  'NO',
                TestCase_Migration::COLUMN_KEY       =>  '',
                TestCase_Migration::COLUMN_DEFAULT   =>  null,
                TestCase_Migration::COLUMN_EXTRA     =>  '',
            ),
            array(
                TestCase_Migration::COLUMN_FIELD     =>  'priority',
                TestCase_Migration::COLUMN_TYPE      =>  'tinyint(3) unsigned',
                TestCase_Migration::COLUMN_NULL      =>  'NO',
                TestCase_Migration::COLUMN_KEY       =>  '',
                TestCase_Migration::COLUMN_DEFAULT   =>  null,
                TestCase_Migration::COLUMN_EXTRA     =>  '',
            ),
            array(
                TestCase_Migration::COLUMN_FIELD     =>  'message',
                TestCase_Migration::COLUMN_TYPE      =>  'text',
                TestCase_Migration::COLUMN_NULL      =>  'NO',
                TestCase_Migration::COLUMN_KEY       =>  '',
                TestCase_Migration::COLUMN_DEFAULT   =>  null,
                TestCase_Migration::COLUMN_EXTRA     =>  '',
            ),
            array(
                TestCase_Migration::COLUMN_FIELD     =>  'identity',
                TestCase_Migration::COLUMN_TYPE      =>  'varchar(40)',
                TestCase_Migration::COLUMN_NULL      =>  'NO',
                TestCase_Migration::COLUMN_KEY       =>  '',
                TestCase_Migration::COLUMN_DEFAULT   =>  null,
                TestCase_Migration::COLUMN_EXTRA     =>  '',
            ),
            array(
                TestCase_Migration::COLUMN_FIELD     =>  'ip_address',
                TestCase_Migration::COLUMN_TYPE      =>  'varchar(39)',
                TestCase_Migration::COLUMN_NULL      =>  'YES',
                TestCase_Migration::COLUMN_KEY       =>  '',
                TestCase_Migration::COLUMN_DEFAULT   =>  null,
                TestCase_Migration::COLUMN_EXTRA     =>  '',
            ),
            array(
                TestCase_Migration::COLUMN_FIELD     =>  'url',
                TestCase_Migration::COLUMN_TYPE      =>  'varchar(255)',
                TestCase_Migration::COLUMN_NULL      =>  'NO',
                TestCase_Migration::COLUMN_KEY       =>  '',
                TestCase_Migration::COLUMN_DEFAULT   =>  null,
                TestCase_Migration::COLUMN_EXTRA     =>  '',
            ),
            array(
                TestCase_Migration::COLUMN_FIELD     =>  'stack_trace',
                TestCase_Migration::COLUMN_TYPE      =>  'text',
                TestCase_Migration::COLUMN_NULL      =>  'YES',
                TestCase_Migration::COLUMN_KEY       =>  '',
                TestCase_Migration::COLUMN_DEFAULT   =>  null,
                TestCase_Migration::COLUMN_EXTRA     =>  '',
            ),
            array(
                TestCase_Migration::COLUMN_FIELD     =>  'post',
                TestCase_Migration::COLUMN_TYPE      =>  'text',
                TestCase_Migration::COLUMN_NULL      =>  'YES',
                TestCase_Migration::COLUMN_KEY       =>  '',
                TestCase_Migration::COLUMN_DEFAULT   =>  null,
                TestCase_Migration::COLUMN_EXTRA     =>  '',
            )
        );
    }
    
}
