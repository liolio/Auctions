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
            $notificationSender->send($user, Enum_Db_Notification_Type::USER_REGISTRATION);
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
        $form = new Auctions_Form_User_SetPassword(array('action' => '/user/process-set-password-and-activate-account-form'));
        $form->getElement(FieldIdEnum::USER_LOGIN)->setValue(
                UserTable::getInstance()->findOneBy(
                        'secret_code', 
                        $this->getRequest()->getParam(FieldIdEnum::USER_SECRET_CODE)
                )->login
                
        );

        $this->view->setPasswordForm = $form;
    }
    
    public function processSetPasswordAndActivateAccountFormAction()
    {
        $request = $this->getRequest();

        if (!$request->isPost())
            return $this->_helper->redirector('registration');

        $form = new Auctions_Form_User_SetPassword(array('action' => '/user/process-set-password-and-activate-account-form'));
        if (!$form->isValid($request->getPost()))
        {
            $this->view->setPasswordForm = $form;
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
            $this->view->setPasswordForm = $form;
            $form->setDescription('Failure!');
            return $this->render('set-password-and-register-account');
        }
        
        $this->_helper->redirector('index', 'index');
    }
    
    public function processChangePasswordAction()
    {
        $request = $this->getRequest();
        
        if (!$request->isPost())
            return $this->_helper->redirector('registration');

        $form = new Auctions_Form_User_ChangePassword();
        if (!$form->isValid($request->getPost()))
        {
            $this->view->changePasswordForm = $form;
            return $this->render('change-password');
        }
        
        try {
            Doctrine_Manager::connection()->beginTransaction();
            $user = UserTable::getInstance()->findOneBy('login', $form->getValue(FieldIdEnum::USER_LOGIN))
                ->setNewPassword($form->getValue(FieldIdEnum::USER_PASSWORD));

            $user->save();
            
            $notificationSender = new Notification_Sender();
            $notificationSender->send($user, Enum_Db_Notification_Type::USER_NEW_PASSWORD_SET);
            
            Doctrine_Manager::connection()->commit();
        }
        catch (Exception $ex)
        {
            Doctrine_Manager::connection()->rollback();
            Log_Factory::create($ex, Zend_Log::CRIT);
            $this->view->changePasswordForm = $form;
            $form->setDescription('Failure!');
            return $this->render('change-password');
        }
        
        $this->_helper->redirector('panel', 'user');
    }
    
    public function passwordResetRequestAction()
    {
        $this->view->passwordResetForm = new Auctions_Form_User_PasswordReset();
    }
    
    public function processPasswordResetFormAction()
    {
        $request = $this->getRequest();

        if (!$request->isPost())
            return $this->_helper->redirector('user', 'password-reset-request');
        
        $form = new Auctions_Form_User_PasswordReset(array('action' => '/user/process-password-reset-form'));
        if (!$form->isValid($request->getPost()))
        {
            $this->view->passwordResetForm = $form;
            return $this->render('password-reset-request');
        }
        
        try {
            Doctrine_Manager::connection()->beginTransaction();
            $user = UserTable::getInstance()->findOneBy('email', $form->getValue(FieldIdEnum::USER_EMAIL));
            $user->setNewSecretCode();
            
            $notificationSender = new Notification_Sender();
            $notificationSender->send($user, Enum_Db_Notification_Type::USER_PASSWORD_RESET);
            Doctrine_Manager::connection()->commit();
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
    
    public function panelAction()
    {
        
    }
    
    public function changePasswordAction()
    {
        $form = new Auctions_Form_User_ChangePassword();
        $form->getElement(FieldIdEnum::USER_LOGIN)->setValue(
            Auth_User::getInstance()->getUser()->login
        );

        $this->view->changePasswordForm = $form;
    }
    
    public function showListAction()
    {
        $this->view->users = UserTable::getInstance()->findAll();
    }
    
    public function resetPasswordByAdministratorAction()
    {
        try {
            Doctrine_Manager::connection()->beginTransaction();
            $user = UserTable::getInstance()->find($this->getRequest()->getParam(FieldIdEnum::USER_ID));
            $user->setNewSecretCode();
            
            $notificationSender = new Notification_Sender();
            $notificationSender->send($user, Enum_Db_Notification_Type::USER_PASSWORD_RESET);
            Doctrine_Manager::connection()->commit();
        }
        catch (Exception $ex)
        {
            Doctrine_Manager::connection()->rollback();
            Log_Factory::create($ex, Zend_Log::CRIT);
            $this->view->users = UserTable::getInstance()->findAll();
            $this->view->message = 'Failure!!!';
            return $this->render('show-list');
        }
        $this->_helper->redirector('show-list', 'user');
    }
    
    public function editAction()
    {
        $this->view->editForm = $this->_getFilledEditForm();
    }
    
    public function processEditFormAction()
    {
         $request = $this->getRequest();

        if (!$request->isPost())
            return $this->_helper->redirector('show-list');
        
        $form = $this->_getFilledEditForm();
        if (!$form->isValid($request->getPost()))
        {
            $this->view->editForm = $form;
            return $this->render('edit');
        }
        
        try {
            Doctrine_Manager::connection()->beginTransaction();

            $user = UserTable::getInstance()->find($request->getParam(FieldIdEnum::USER_ID));
            $user->login = $form->getValue(FieldIdEnum::USER_LOGIN);
            $user->email = $form->getValue(FieldIdEnum::USER_EMAIL);
            $user->active = $form->getValue(FieldIdEnum::USER_ACTIVE);
            $user->role = $form->getValue(FieldIdEnum::USER_ROLE);
            
            $user->save();
            
            Doctrine_Manager::connection()->commit();
        }
        catch (Exception $ex)
        {
            Doctrine_Manager::connection()->rollback();
            Log_Factory::create($ex, Zend_Log::CRIT);
            $this->view->editForm = $form;
            $form->setDescription('Failure!');
            return $this->render('edit');
        }
        
        $this->_helper->redirector('show-list', 'user');
    }
    
    public function deleteAction()
    {
        $userId = $this->getRequest()->getParam(FieldIdEnum::USER_ID);

        if ($userId === Auth_User::getInstance()->getUser()->id)
        {
            $this->showListAction();
            $this->view->message = Helper::getTranslator()->translate('validation_message-cannot_delete_your_own_account');
            return $this->render('show-list');
        }
        
        try {
            Doctrine_Manager::connection()->beginTransaction();
            UserTable::getInstance()->findOneBy('id', $userId)->delete();
            Doctrine_Manager::connection()->commit();
        }
        catch (Exception $ex)
        {
            Doctrine_Manager::connection()->rollback();
            Log_Factory::create($ex, Zend_Log::CRIT);
        }
        
        $this->_helper->redirector('show-list', 'user');
    }
    
    private function _getFilledEditForm()
    {
        $userId = $this->getRequest()->getParam(FieldIdEnum::USER_ID);
        
        $form = new Auctions_Form_User_Edit();
        
        if (!is_null($userId))
        {
            $user = UserTable::getInstance()->find($userId);
            
            if ($user !== false)
            {
                $form->getElement(FieldIdEnum::USER_ID)->setValue($userId);
                $form->getElement(FieldIdEnum::USER_EMAIL)->setValue($user->email);
                $form->getElement(FieldIdEnum::USER_ACTIVE)->setValue($user->active);
                $form->getElement(FieldIdEnum::USER_LOGIN)->setValue($user->login);
                $form->getElement(FieldIdEnum::USER_ROLE)->setValue($user->role);
            }
        }
        
        return $form;
    }
}
