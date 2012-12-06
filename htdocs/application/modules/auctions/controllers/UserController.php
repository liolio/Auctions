<?php
/**
 * @class Auctions_UserController
 */
class Auctions_UserController extends Zend_Controller_Action
{
    
    public function init()
    {
        Zend_Layout::startMvc();
    }
    
    public function registrationAction()
    {
        $this->view->registrationForm = new Auctions_Form_User_Registration();
    }
    
    public function processRegistrationFormAction()
    {
        $request = $this->getRequest();

        if (!$request->isPost())
            return $this->_helper->redirector('registration');

        $form = new Auctions_Form_User_Registration();
        if (!$form->isValid($request->getPost()))
        {
            $this->view->registrationForm = $form;
            return $this->render('registration');
        }
        
        try {
            Doctrine_Manager::connection()->beginTransaction();
            $user = User_Factory::create(
                    $form->getValue(FieldIdEnum::USER_LOGIN),
                    $form->getValue(FieldIdEnum::USER_EMAIL),
                    User_SecurityCode_Generator::generate()
            );

            $user->save();
            
            $address = Address_Factory::create($user, array(
                FieldIdEnum::ADDRESS_NAME           =>  $form->getValue(FieldIdEnum::ADDRESS_NAME),
                FieldIdEnum::ADDRESS_SURNAME        =>  $form->getValue(FieldIdEnum::ADDRESS_SURNAME),
                FieldIdEnum::ADDRESS_STREET         =>  $form->getValue(FieldIdEnum::ADDRESS_STREET),
                FieldIdEnum::ADDRESS_POSTAL_CODE    =>  $form->getValue(FieldIdEnum::ADDRESS_POSTAL_CODE),
                FieldIdEnum::ADDRESS_CITY           =>  $form->getValue(FieldIdEnum::ADDRESS_CITY),
                FieldIdEnum::ADDRESS_COUNTRY        =>  $form->getValue(FieldIdEnum::ADDRESS_COUNTRY),
                FieldIdEnum::ADDRESS_PHONE_NUMBER   =>  $form->getValue(FieldIdEnum::ADDRESS_PHONE_NUMBER),
                FieldIdEnum::ADDRESS_PROVINCE       =>  $form->getValue(FieldIdEnum::ADDRESS_PROVINCE)
            ));
            
            $address->save();

            $notificationSender = new Notification_Sender();
            $notificationSender->send($user, DbEnum_Notification_Type::USER_REGISTRATION);
            Doctrine_Manager::connection()->commit();
        }
        catch (Exception $ex)
        {
            Doctrine_Manager::connection()->rollback();
            Log_Factory::create($ex, Zend_Log::CRIT);
            $this->view->registrationForm = $form;
            $form->setDescription('Failure!');
            return $this->render('registration');
        }
        
        $this->_helper->redirector('index', 'index');
    }
    
    public function setPasswordAndRegisterAccountAction()
    {
        $form = new Auctions_Form_User_ChangePassword(array('action' => '/user/process-change-password-and-activate-account-form'));
        $form->getElement(FieldIdEnum::USER_LOGIN)->setValue(
                UserTable::getInstance()->findOneBy(
                        'secret_code', 
                        $this->getRequest()->getParam(FieldIdEnum::USER_SECRET_CODE)
                )->login
                
        );

        $this->view->changePasswordForm = $form;
    }
    
    public function processChangePasswordAndActivateAccountFormAction()
    {
        $request = $this->getRequest();

        if (!$request->isPost())
            return $this->_helper->redirector('registration');

        $form = new Auctions_Form_User_ChangePassword(array('action' => '/user/process-change-password-and-activate-account-form'));
        if (!$form->isValid($request->getPost()))
        {
            $this->view->changePasswordForm = $form;
            return $this->render('set-password-and-register-account');
        }
        
        try {
            Doctrine_Manager::connection()->beginTransaction();
            $user = UserTable::getInstance()->findOneBy('login', $form->getValue(FieldIdEnum::USER_LOGIN))
                ->setNewPassword($form->getValue(FieldIdEnum::USER_PASSWORD))
                ->resetSecretCode()
                ->activateAccount();

            $user->save();
            
            Doctrine_Manager::connection()->commit();
            
            Zend_Auth::getInstance()->authenticate(new Auth_Adapter($user->login, $form->getValue(FieldIdEnum::USER_PASSWORD)));
        }
        catch (Exception $ex)
        {
            Doctrine_Manager::connection()->rollback();
            Log_Factory::create($ex, Zend_Log::CRIT);
            $this->view->changePasswordForm = $form;
            $form->setDescription('Failure!');
            return $this->render('set-password-and-register-account');
        }
        
        $this->_helper->redirector('index', 'index');
    }
}
