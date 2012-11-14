<?php
/**
 * @class User_SecurityCode_Generator
 */
class User_SecurityCode_Generator
{

    public static function generate($length = 40)
    {
        if (!is_int($length) || $length < 1)
            throw new InvalidArgumentException('Length must be positive integer greater than 0');
            
        $securityCode = '';
        
        for ($i = 0; $i <= ($length - ($length % 40)) / 40; $i++)
            $securityCode .= sha1(uniqid() . microtime());
        
        return substr($securityCode, 0, $length);
    }
}
