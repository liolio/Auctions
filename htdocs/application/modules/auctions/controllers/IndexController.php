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
        $this->view->asd = $this->_getBaseStructure();
    }

    public function nextAction()
    {
        Zend_Debug::dump(UserTable::getInstance()->findAll()->toArray());
        $this->view->asd = 'asd';
    }
    
    private function _getBaseStructure()
    {
        return "
        
        <div class='colmask'>
            <div class='header'>
                header
            </div>
            <div class='colmid'>
                <div class='colleft'>
                    <div class='col1'>
                        mid
                    </div>
                    <div class='col2'>
                        left
                    </div> 
                    <div class='col3'>
                        right
                    </div> 
                </div> 
            </div>
            <div class='footer'>
                footer
            </div>
        </div>
        </body>
        ";

    }
}
