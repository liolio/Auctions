<?php
/**
 * @class Time_Format
 */
class Time_Format
{
    
    /**
     * Returns format: 2012-10-28 22:54:00
     * 
     * @return String 
     */
    public static function getFullDateTimeFormat()
    {
        return Zend_Date::YEAR . '-' . Zend_Date::MONTH . '-' . Zend_Date::DAY . ' '
                . Zend_Date::HOUR . ':' . Zend_Date::MINUTE . ':' . Zend_Date::SECOND;
    }
}
