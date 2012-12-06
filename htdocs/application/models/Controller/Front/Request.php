<?php
/**
 * @class Controller_Front_Request
 */
class Controller_Front_Request
{
    
    public static function getRole()
    {
        $user = Auth_User::getInstance()->getUser();
        if (is_null($user))
            return Acl_RoleEnum::GUEST;
        
        return $user->role;
    }
    
    public static function getResource(Zend_Controller_Request_Abstract $request)
    {
        return ucfirst($request->getModuleName()) . ':' . ucfirst($request->getControllerName());
    }
    
    public static function getPrivilege(Zend_Controller_Request_Abstract $request)
    {
        return $request->getActionName();
    } 
}
