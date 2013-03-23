<?php
/**
 * @class Enum_Acl_Resource
 */
class Enum_Acl_Resource extends Enum_Abstract
{
    
    const AUTH = "Auctions:Auth";
    
    const ERROR = "Auctions:Error";
    
    const INDEX = "Auctions:Index";
    
    const USER = "Auctions:User";
    
    const ADDRESS = "Auctions:Address";
    
    public static function getControllerName($enum)
    {
        $exploded = explode(":", $enum);
        return strtolower($exploded[1]);
    }
}
