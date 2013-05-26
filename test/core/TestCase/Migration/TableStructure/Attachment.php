<?php
/**
 * @class TestCase_Migration_TableStructure_Attachment
 */
class TestCase_Migration_TableStructure_Attachment implements TestCase_Migration_TableStructure
{
    
    public static function getStructure($versionNumber)
    {
        if ($versionNumber < 23)
            throw new InvalidArgumentException($versionNumber . " not supported.");
        
        switch ($versionNumber)
        {
            
            case 23 :
                return self::_getStructureFromVersion23();
            default :
                return self::_getStructureFromVersion24();
        }
    }
    
    private static function _getStructureFromVersion23()
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
                TestCase_Migration::COLUMN_FIELD     =>  'auction_id',
                TestCase_Migration::COLUMN_TYPE      =>  'bigint(20) unsigned',
                TestCase_Migration::COLUMN_NULL      =>  'NO',
                TestCase_Migration::COLUMN_KEY       =>  'MUL',
                TestCase_Migration::COLUMN_DEFAULT   =>  null,
                TestCase_Migration::COLUMN_EXTRA     =>  '',
            ),
            array(
                TestCase_Migration::COLUMN_FIELD     =>  'file_id',
                TestCase_Migration::COLUMN_TYPE      =>  'bigint(20) unsigned',
                TestCase_Migration::COLUMN_NULL      =>  'NO',
                TestCase_Migration::COLUMN_KEY       =>  '',
                TestCase_Migration::COLUMN_DEFAULT   =>  null,
                TestCase_Migration::COLUMN_EXTRA     =>  '',
            ),
        );
    }
    
    private static function _getStructureFromVersion24()
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
                TestCase_Migration::COLUMN_FIELD     =>  'auction_id',
                TestCase_Migration::COLUMN_TYPE      =>  'bigint(20) unsigned',
                TestCase_Migration::COLUMN_NULL      =>  'NO',
                TestCase_Migration::COLUMN_KEY       =>  'MUL',
                TestCase_Migration::COLUMN_DEFAULT   =>  null,
                TestCase_Migration::COLUMN_EXTRA     =>  '',
            ),
            array(
                TestCase_Migration::COLUMN_FIELD     =>  'file_id',
                TestCase_Migration::COLUMN_TYPE      =>  'bigint(20) unsigned',
                TestCase_Migration::COLUMN_NULL      =>  'NO',
                TestCase_Migration::COLUMN_KEY       =>  'MUL',
                TestCase_Migration::COLUMN_DEFAULT   =>  null,
                TestCase_Migration::COLUMN_EXTRA     =>  '',
            ),
        );
    }
    
}
