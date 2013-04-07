<?php
/**
 * @class TestCase_Migration_TableStructure_Address
 */
class TestCase_Migration_TableStructure_Address implements TestCase_Migration_TableStructure
{
    
    public static function getStructure($versionNumber)
    {
        switch ($versionNumber)
        {
            case 5 :
                return self::_getStructureFromVersion5();
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
            case 18 :
            case 19 :
            case 20 :
            case 21 :
            case 22 :
                return self::_getStructureFromVersion6();
            default :
                throw new InvalidArgumentException($versionNumber . " not supported.");
        }
    }
    
    private static function _getStructureFromVersion5()
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
                TestCase_Migration::COLUMN_FIELD     =>  'surname',
                TestCase_Migration::COLUMN_TYPE      =>  'varchar(100)',
                TestCase_Migration::COLUMN_NULL      =>  'YES',
                TestCase_Migration::COLUMN_KEY       =>  '',
                TestCase_Migration::COLUMN_DEFAULT   =>  null,
                TestCase_Migration::COLUMN_EXTRA     =>  '',
            ),
            array(
                TestCase_Migration::COLUMN_FIELD     =>  'street',
                TestCase_Migration::COLUMN_TYPE      =>  'varchar(100)',
                TestCase_Migration::COLUMN_NULL      =>  'NO',
                TestCase_Migration::COLUMN_KEY       =>  '',
                TestCase_Migration::COLUMN_DEFAULT   =>  null,
                TestCase_Migration::COLUMN_EXTRA     =>  '',
            ),
            array(
                TestCase_Migration::COLUMN_FIELD     =>  'postal_code',
                TestCase_Migration::COLUMN_TYPE      =>  'varchar(10)',
                TestCase_Migration::COLUMN_NULL      =>  'NO',
                TestCase_Migration::COLUMN_KEY       =>  '',
                TestCase_Migration::COLUMN_DEFAULT   =>  null,
                TestCase_Migration::COLUMN_EXTRA     =>  '',
            ),
            array(
                TestCase_Migration::COLUMN_FIELD     =>  'city',
                TestCase_Migration::COLUMN_TYPE      =>  'varchar(100)',
                TestCase_Migration::COLUMN_NULL      =>  'NO',
                TestCase_Migration::COLUMN_KEY       =>  '',
                TestCase_Migration::COLUMN_DEFAULT   =>  null,
                TestCase_Migration::COLUMN_EXTRA     =>  '',
            ),
            array(
                TestCase_Migration::COLUMN_FIELD     =>  'province',
                TestCase_Migration::COLUMN_TYPE      =>  'varchar(100)',
                TestCase_Migration::COLUMN_NULL      =>  'NO',
                TestCase_Migration::COLUMN_KEY       =>  '',
                TestCase_Migration::COLUMN_DEFAULT   =>  null,
                TestCase_Migration::COLUMN_EXTRA     =>  '',
            ),
            array(
                TestCase_Migration::COLUMN_FIELD     =>  'country',
                TestCase_Migration::COLUMN_TYPE      =>  'varchar(100)',
                TestCase_Migration::COLUMN_NULL      =>  'NO',
                TestCase_Migration::COLUMN_KEY       =>  '',
                TestCase_Migration::COLUMN_DEFAULT   =>  null,
                TestCase_Migration::COLUMN_EXTRA     =>  '',
            ),
            array(
                TestCase_Migration::COLUMN_FIELD     =>  'phone_number',
                TestCase_Migration::COLUMN_TYPE      =>  'varchar(15)',
                TestCase_Migration::COLUMN_NULL      =>  'NO',
                TestCase_Migration::COLUMN_KEY       =>  '',
                TestCase_Migration::COLUMN_DEFAULT   =>  null,
                TestCase_Migration::COLUMN_EXTRA     =>  '',
            ),
            array(
                TestCase_Migration::COLUMN_FIELD     =>  'user_id',
                TestCase_Migration::COLUMN_TYPE      =>  'bigint(20) unsigned',
                TestCase_Migration::COLUMN_NULL      =>  'NO',
                TestCase_Migration::COLUMN_KEY       =>  '',
                TestCase_Migration::COLUMN_DEFAULT   =>  null,
                TestCase_Migration::COLUMN_EXTRA     =>  '',
            ),
        );
    }
    
    private static function _getStructureFromVersion6()
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
                TestCase_Migration::COLUMN_FIELD     =>  'surname',
                TestCase_Migration::COLUMN_TYPE      =>  'varchar(100)',
                TestCase_Migration::COLUMN_NULL      =>  'YES',
                TestCase_Migration::COLUMN_KEY       =>  '',
                TestCase_Migration::COLUMN_DEFAULT   =>  null,
                TestCase_Migration::COLUMN_EXTRA     =>  '',
            ),
            array(
                TestCase_Migration::COLUMN_FIELD     =>  'street',
                TestCase_Migration::COLUMN_TYPE      =>  'varchar(100)',
                TestCase_Migration::COLUMN_NULL      =>  'NO',
                TestCase_Migration::COLUMN_KEY       =>  '',
                TestCase_Migration::COLUMN_DEFAULT   =>  null,
                TestCase_Migration::COLUMN_EXTRA     =>  '',
            ),
            array(
                TestCase_Migration::COLUMN_FIELD     =>  'postal_code',
                TestCase_Migration::COLUMN_TYPE      =>  'varchar(10)',
                TestCase_Migration::COLUMN_NULL      =>  'NO',
                TestCase_Migration::COLUMN_KEY       =>  '',
                TestCase_Migration::COLUMN_DEFAULT   =>  null,
                TestCase_Migration::COLUMN_EXTRA     =>  '',
            ),
            array(
                TestCase_Migration::COLUMN_FIELD     =>  'city',
                TestCase_Migration::COLUMN_TYPE      =>  'varchar(100)',
                TestCase_Migration::COLUMN_NULL      =>  'NO',
                TestCase_Migration::COLUMN_KEY       =>  '',
                TestCase_Migration::COLUMN_DEFAULT   =>  null,
                TestCase_Migration::COLUMN_EXTRA     =>  '',
            ),
            array(
                TestCase_Migration::COLUMN_FIELD     =>  'province',
                TestCase_Migration::COLUMN_TYPE      =>  'varchar(100)',
                TestCase_Migration::COLUMN_NULL      =>  'NO',
                TestCase_Migration::COLUMN_KEY       =>  '',
                TestCase_Migration::COLUMN_DEFAULT   =>  null,
                TestCase_Migration::COLUMN_EXTRA     =>  '',
            ),
            array(
                TestCase_Migration::COLUMN_FIELD     =>  'country',
                TestCase_Migration::COLUMN_TYPE      =>  'varchar(100)',
                TestCase_Migration::COLUMN_NULL      =>  'NO',
                TestCase_Migration::COLUMN_KEY       =>  '',
                TestCase_Migration::COLUMN_DEFAULT   =>  null,
                TestCase_Migration::COLUMN_EXTRA     =>  '',
            ),
            array(
                TestCase_Migration::COLUMN_FIELD     =>  'phone_number',
                TestCase_Migration::COLUMN_TYPE      =>  'varchar(15)',
                TestCase_Migration::COLUMN_NULL      =>  'NO',
                TestCase_Migration::COLUMN_KEY       =>  '',
                TestCase_Migration::COLUMN_DEFAULT   =>  null,
                TestCase_Migration::COLUMN_EXTRA     =>  '',
            ),
            array(
                TestCase_Migration::COLUMN_FIELD     =>  'user_id',
                TestCase_Migration::COLUMN_TYPE      =>  'bigint(20) unsigned',
                TestCase_Migration::COLUMN_NULL      =>  'NO',
                TestCase_Migration::COLUMN_KEY       =>  'MUL',
                TestCase_Migration::COLUMN_DEFAULT   =>  null,
                TestCase_Migration::COLUMN_EXTRA     =>  '',
            ),
        );
    }
    
}
