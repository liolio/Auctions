<?php
/**
 * @class Auctions_BankingInformationController
 */
class Auctions_BankingInformationController extends Controller_Abstract
{
    
    public function init()
    {
        Zend_Layout::startMvc();
    }
    
    public function showListAction()
    {
        $this->view->list = Auth_User::getInstance()->getUser()->BankingInformations;
    }
    
}
