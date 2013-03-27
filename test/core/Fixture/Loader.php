<?php
/**
 * @class Fixture_Loader
 */
class Fixture_Loader
{
    
    public static function create($path)
    {
        if (!is_string($path))
            throw new InvalidArgumentException('Fixture path name must be a string');
        
        $path = str_replace(array('/', '\\'), DIRECTORY_SEPARATOR, $path);
        
        Doctrine_Manager::getInstance()->getCurrentConnection()->exec(file_get_contents(FIXTURE_PATH . DIRECTORY_SEPARATOR . $path . '.sql'));
    }
    
    public static function createAll(array $paths)
    {
        foreach ($paths as $path)
            self::create($path);
    }
}
