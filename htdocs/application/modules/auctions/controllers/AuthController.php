<?php
/**
 * @class Auctions_AuthController
 */
class Auctions_AuthController extends Controller_Abstract
{

    public function init()
    {
        Zend_Layout::startMvc();
    }

    public function indexAction()
    {
        $this->view->form = new Auctions_Form_LogIn();
    }
    
    public function processAction()
    {
        $request = $this->getRequest();

        if (!$request->isPost()) {
            return $this->_helper->redirector('index');
        }

        $form = new Auctions_Form_LogIn();
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
                case Auth_Result::FAILURE_NOT_ACTIVE:
                    $form->setDescription($this->_getTranslator()->translate('validation_message-user_inactive'));
                    break;
                case Auth_Result::FAILURE_IDENTITY_NOT_FOUND :
                case Auth_Result::FAILURE_CREDENTIAL_INVALID :
                default :
                    $form->setDescription($this->_getTranslator()->translate('validation_message-invalid_credentials'));
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
}