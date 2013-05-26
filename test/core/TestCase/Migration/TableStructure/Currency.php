<?php
/**
 * @class TestCase_Migration_TableStructure_Currency
 */
class TestCase_Migration_TableStructure_Currency implements TestCase_Migration_TableStructure
{
    
    public static function getStructure($versionNumber)
    {
        switch ($versionNumber)
        {
            case 13 :
            case 14 :
            case 15 :
            case 16 :
            case 17 :
            case 18 :
            case 19 :
            case 20 :
            case 21 :
            case 22 :
            case 23 :
            case 24 :
            case 25 :
            case 26 :
            case 27 :
            case 28 :
                return self::_getStructureFromVersion13();
            default :
                throw new InvalidArgumentException($versionNumber . " not supported.");
        }
    }
    
    private static function _getStructureFromVersion13()
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
        );
    }
    
}
