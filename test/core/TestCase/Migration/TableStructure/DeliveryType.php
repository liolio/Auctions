<?php
/**
 * @class TestCase_Migration_TableStructure_DeliveryType
 */
class TestCase_Migration_TableStructure_DeliveryType implements TestCase_Migration_TableStructure
{
    
    public static function getStructure($versionNumber)
    {
        switch ($versionNumber)
        {
            case 25 :
            case 26 :
            case 27 :
            case 28 :
                return self::_getStructureFromVersion25();
            default :
                throw new InvalidArgumentException($versionNumber . " not supported.");
        }
    }
    
    private static function _getStructureFromVersion25()
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
                TestCase_Migration::COLUMN_KEY       =>  'MUL',
                TestCase_Migration::COLUMN_DEFAULT   =>  null,
                TestCase_Migration::COLUMN_EXTRA     =>  '',
            ),
            array(
                TestCase_Migration::COLUMN_FIELD     =>  'cash_on_delivery',
                TestCase_Migration::COLUMN_TYPE      =>  'tinyint(1)',
                TestCase_Migration::COLUMN_NULL      =>  'NO',
                TestCase_Migration::COLUMN_KEY       =>  '',
                TestCase_Migration::COLUMN_DEFAULT   =>  null,
                TestCase_Migration::COLUMN_EXTRA     =>  '',
            ),
        );
    }
    
}
