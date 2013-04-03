<?php
/**
 * @class TestCase_Migration_TableStructure_MigrationVersion
 */
class TestCase_Migration_TableStructure_MigrationVersion implements TestCase_Migration_TableStructure
{
    
    public static function getStructure($versionNumber)
    {
        switch ($versionNumber)
        {
            case 1 :
            case 2 :
            case 3 :
            case 4 :
            case 5 :
            case 6 :
            case 7 :
            case 8 :
            case 9 :
            case 10 :
            case 11 :
            case 12 :
            case 13 :
            case 14 :
            case 15 :
            case 16 :
            case 17 :
                return self::_getStructureFromVersion1();
            default :
                throw new InvalidArgumentException($versionNumber . " not supported.");
        }
    }
    
    private static function _getStructureFromVersion1()
    {
        return array(
            array(
                TestCase_Migration::COLUMN_FIELD     =>  'version',
                TestCase_Migration::COLUMN_TYPE      =>  'int(11)',
                TestCase_Migration::COLUMN_NULL      =>  'YES',
                TestCase_Migration::COLUMN_KEY       =>  '',
                TestCase_Migration::COLUMN_DEFAULT   =>  null,
                TestCase_Migration::COLUMN_EXTRA     =>  '',
            )
        );
    }
    
}
