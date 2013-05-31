<?php
/**
 * @class Enum_Acl_Resource
 */
class Enum_Acl_Resource extends Enum_Abstract
{
    
    const ADDRESS = "Auctions:Address";
    
    const ADMINISTRATOR = "Auctions:Administrator";
    
    const AUCTION = "Auctions:Auction";
    
    const AUTH = "Auctions:Auth";
    
    const BANKING_INFORMATION = "Auctions:Banking-information";
    
    const CATEGORY = "Auctions:Category";
    
    const CURRENCY = "Auctions:Currency";
    
    const DELIVERY_FORM = "Auctions:Delivery-form";
    
    const DELIVERY_TYPE = "Auctions:Delivery-type";
    
    const ERROR = "Auctions:Error";
    
    const FILE = "Auctions:File";
    
    const INDEX = "Auctions:Index";
    
    const TRANSACTION = "Auctions:Transaction";
    
    const USER = "Auctions:User";
    
    public static function getControllerName($enum)
    {
        $exploded = explode(":", $enum);
        return strtolower($exploded[1]);
    }
}
