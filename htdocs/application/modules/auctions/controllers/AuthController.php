<?php
/**
 * @class Auctions_AuthController
 */
class Auctions_AuthController extends Zend_Controller_Action
{

    public function init()
    {
        
    }

    public function indexAction()
    {
        $this->view->form = $this->_getLoginForm();
    }
    
    public function processAction()
    {
        $request = $this->getRequest();

        if (!$request->isPost()) {
            return $this->_helper->redirector('index');
        }

        $form = $this->_getLoginForm();
        if (!$form->isValid($request->getPost()))
        {
            $this->view->form = $form;
            return $this->render('index');
        }

        $logInResult = Zend_Auth::getInstance()->authenticate(new Auth_Adapter($form->getValue(FieldIdEnum::USER_LOGIN), $form->getValue(FieldIdEnum::USER_PASSWORD)));
        if (! $logInResult->isValid())
        {
            switch ($logInResult->getCode())
            {
                case Zend_Auth_Result::FAILURE_IDENTITY_NOT_FOUND :
                    $form->setDescription('No such user');
                    break;
                default :
                    $form->setDescription('Invalid credentials provided');
                    break;
            }
            
            $this->view->form = $form;
            return $this->render('index');
        }

        $this->_helper->redirector('index', 'index');
    }
    
    public function logoutAction()
    {
        Zend_Auth::getInstance()->clearIdentity();
        $this->_helper->redirector('index', 'index');
    }

    /**
     * @return Auctions_Form_Login
     */
    private function _getLoginForm()
    {
        return new Auctions_Form_Login(array(
            'action' => '/login/process',
            'method' => 'post',
        ));
    }
}