<?php
/**
 * @class Auctions_IndexController
 */
class Auctions_IndexController extends Controller_Abstract
{

    public function indexAction()
    {
        $this->view->openDialogWindow = Session_DialogWindow::getValue();
        $this->view->newses = NewsTable::getInstance()->createQuery()
                ->orderBy('created_at DESC')
                ->execute();
    }
}
