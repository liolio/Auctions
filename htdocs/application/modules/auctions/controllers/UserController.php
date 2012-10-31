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
    
    public function processRegistrationAction()
    {
        $request = $this->getRequest();

        if (!$request->isPost()) {
            return $this->_helper->redirector('registration');
        }

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

            $notificationBulder = new Notification_Builder();
            $notificationBulder->build($user, DbEnum_Notification_Type::USER_REGISTRATION);
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
}
