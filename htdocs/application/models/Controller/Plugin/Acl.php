<?php
/**
 * @class Controller_Plugin_Acl
 */
class Controller_Plugin_Acl extends Zend_Controller_Plugin_Abstract
{
    
    public function preDispatch(Zend_Controller_Request_Abstract $request)
    {
        parent::preDispatch($request);
        $acl = new Acl();
        
        if (!$acl->isAllowed($this->_getRole(), $this->_getResource($request), $this->_getPrivilege($request)))
        {
//            Zend_Debug::dump($this->_getRole() . ' | ' . $this->_getResource($request) . ' | ' . $this->_getPrivilege($request));die;
            $request->setModuleName('auctions')
                    ->setControllerName('index')
                    ->setActionName('index');
        }
    }
    
    private function _getRole()
    {
        $user = Auth_User::getInstance()->getUser();
        if (is_null($user))
            return Enum_Acl_Role::GUEST;
        
        return $user->role;
    }
    
    private function _getResource(Zend_Controller_Request_Abstract $request)
    {
        return ucfirst($request->getModuleName()) . ':' . ucfirst($request->getControllerName());
    }
    
    protected function _getPrivilege(Zend_Controller_Request_Abstract $request)
    {
        return $request->getActionName();
    }   
}
