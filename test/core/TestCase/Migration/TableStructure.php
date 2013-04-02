<?php
/**
 * @interface TestCase_Migration_TableStructure
 */
interface TestCase_Migration_TableStructure
{
    
    /**
     * Returns table structure based on version number.
     * 
     * @param Integer $versionNumber
     * @return array with table structure
     */
    public static function getStructure($versionNumber);
    
}
