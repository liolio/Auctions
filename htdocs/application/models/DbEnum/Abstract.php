<?php
/**
 * @class DbEnum_Abstract
 */
abstract class DbEnum_Abstract
{
    
    public static function hasEnum($enumName)
    {
        $reflection = new ReflectionClass(get_called_class());
                
        return array_search($enumName, $reflection->getConstants()) !== false;
    }
}
