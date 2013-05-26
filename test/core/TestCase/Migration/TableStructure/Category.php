<?php
/**
 * @class TestCase_Migration_TableStructure_Category
 */
class TestCase_Migration_TableStructure_Category implements TestCase_Migration_TableStructure
{
    
    public static function getStructure($versionNumber)
    {
        if ($versionNumber < 9)
            throw new InvalidArgumentException($versionNumber . " not supported.");
        
        switch ($versionNumber)
        {
            case 9 :
                return self::_getStructureFromVersion9();
            default :
                return self::_getStructureFromVersion10();
        }
    }
    
    private static function _getStructureFromVersion9()
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
                TestCase_Migration::COLUMN_KEY       =>  '',
                TestCase_Migration::COLUMN_DEFAULT   =>  null,
                TestCase_Migration::COLUMN_EXTRA     =>  '',
            ),
            array(
                TestCase_Migration::COLUMN_FIELD     =>  'description',
                TestCase_Migration::COLUMN_TYPE      =>  'varchar(255)',
                TestCase_Migration::COLUMN_NULL      =>  'YES',
                TestCase_Migration::COLUMN_KEY       =>  '',
                TestCase_Migration::COLUMN_DEFAULT   =>  null,
                TestCase_Migration::COLUMN_EXTRA     =>  '',
            ),
            array(
                TestCase_Migration::COLUMN_FIELD     =>  'parent_category_id',
                TestCase_Migration::COLUMN_TYPE      =>  'bigint(20) unsigned',
                TestCase_Migration::COLUMN_NULL      =>  'YES',
                TestCase_Migration::COLUMN_KEY       =>  '',
                TestCase_Migration::COLUMN_DEFAULT   =>  null,
                TestCase_Migration::COLUMN_EXTRA     =>  '',
            ),
        );
    }
    
    private static function _getStructureFromVersion10()
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
                TestCase_Migration::COLUMN_KEY       =>  '',
                TestCase_Migration::COLUMN_DEFAULT   =>  null,
                TestCase_Migration::COLUMN_EXTRA     =>  '',
            ),
            array(
                TestCase_Migration::COLUMN_FIELD     =>  'description',
                TestCase_Migration::COLUMN_TYPE      =>  'varchar(255)',
                TestCase_Migration::COLUMN_NULL      =>  'YES',
                TestCase_Migration::COLUMN_KEY       =>  '',
                TestCase_Migration::COLUMN_DEFAULT   =>  null,
                TestCase_Migration::COLUMN_EXTRA     =>  '',
            ),
            array(
                TestCase_Migration::COLUMN_FIELD     =>  'parent_category_id',
                TestCase_Migration::COLUMN_TYPE      =>  'bigint(20) unsigned',
                TestCase_Migration::COLUMN_NULL      =>  'YES',
                TestCase_Migration::COLUMN_KEY       =>  'MUL',
                TestCase_Migration::COLUMN_DEFAULT   =>  null,
                TestCase_Migration::COLUMN_EXTRA     =>  '',
            ),
        );
    }
    
}
