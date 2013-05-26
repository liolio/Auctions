<?php
/**
 * @class TestCase_Migration_TableStructure_MigrationVersion
 */
class TestCase_Migration_TableStructure_MigrationVersion implements TestCase_Migration_TableStructure
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
