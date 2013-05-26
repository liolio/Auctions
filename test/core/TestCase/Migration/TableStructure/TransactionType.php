<?php
/**
 * @class TestCase_Migration_TableStructure_TransactionType
 */
class TestCase_Migration_TableStructure_TransactionType implements TestCase_Migration_TableStructure
{
    
    public static function getStructure($versionNumber)
    {
        if ($versionNumber < 15)
            throw new InvalidArgumentException($versionNumber . " not supported.");
        
        switch ($versionNumber)
        {
            default :
                return self::_getStructureFromVersion15();
        }
    }
    
    private static function _getStructureFromVersion15()
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
                TestCase_Migration::COLUMN_FIELD     =>  'name',
                TestCase_Migration::COLUMN_TYPE      =>  'varchar(100)',
                TestCase_Migration::COLUMN_NULL      =>  'NO',
                TestCase_Migration::COLUMN_KEY       =>  'UNI',
                TestCase_Migration::COLUMN_DEFAULT   =>  null,
                TestCase_Migration::COLUMN_EXTRA     =>  '',
            ),
        );
    }
    
}
