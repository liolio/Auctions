<?php
/**
 * @class Enum_Acl_Resource
 */
class Enum_Acl_Resource extends Enum_Abstract
{
    
    const ADDRESS = "Auctions:Address";
    
    const ADMINISTRATOR = "Auctions:Administrator";
    
    const AUTH = "Auctions:Auth";
    
    const BANKING_INFORMATION = "Auctions:Banking-information";
    
    const CATEGORY = "Auctions:Category";
    
    const ERROR = "Auctions:Error";
    
    const INDEX = "Auctions:Index";
    
    const USER = "Auctions:User";
    
    public static function getControllerName($enum)
    {
        $exploded = explode(":", $enum);
        return strtolower($exploded[1]);
    }
}
