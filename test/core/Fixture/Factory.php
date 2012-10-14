<?php
/**
 * @class Fixture_Factory
 */
class Fixture_Factory
{
    
    public static function create($path)
    {
        if (!is_string($path))
            throw new InvalidArgumentException('Fixture path name must be a string');
        
        $path = str_replace(array('/', '\\'), DIRECTORY_SEPARATOR, $path);
        
//        Doctrine_Manager::getInstance()->getConnection(Zend_r)
    }
}
