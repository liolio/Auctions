<?php
/**
 * @class Auctions_AddressController
 */
class Auctions_AddressController extends Zend_Controller_Action
{
    
    public function init()
    {
        Zend_Layout::startMvc();
    }
    
    public function showListAction()
    {
        $this->view->addressList = Auth_User::getInstance()->getUser()->Addresses;
    }
}
