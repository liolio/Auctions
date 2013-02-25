<?php
/**
 * @class Enum_Abstract
 */
abstract class Enum_Abstract
{
    
    public static function hasEnum($enumName)
    {
        $reflection = new ReflectionClass(get_called_class());
                
        return array_search($enumName, $reflection->getConstants()) !== false;
    }
    
    public static function getEnums()
    {
        $reflection = new ReflectionClass(get_called_class());
                
        return $reflection->getConstants();
    }
}
