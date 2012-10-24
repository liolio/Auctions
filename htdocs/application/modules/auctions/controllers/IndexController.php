<?php
/**
 * @class Auctions_IndexController
 */
class Auctions_IndexController extends Zend_Controller_Action
{

    public function init()
    {
        
    }

    public function indexAction()
    {
        $this->view->identity = Zend_Auth::getInstance()->getIdentity();
    }
}
