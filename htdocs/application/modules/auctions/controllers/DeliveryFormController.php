<?php
/**
 * @class Auctions_DeliveryFormController
 */
class Auctions_DeliveryFormController extends Controller_Abstract
{
    
    public function init()
    {
        Zend_Layout::startMvc();
    }
    
    public function fillAction()
    {
        if (!Zend_Auth::getInstance()->hasIdentity())
        {
            Session_LastVisited::save($this->getRequest()->getRequestUri());
            $this->_helper->redirector('index', 'login');
        }
        
        $deliveryForm = DeliveryFormTable::getInstance()->find($this->getRequest()->getParam(FieldIdEnum::DELIVERY_FORM_ID));
        
        $this->view->form = new Auctions_Form_DeliveryForm_Add($deliveryForm);
    }
    
    public function processAddFormAction()
    {
        $request = $this->getRequest();
        
        if (!$request->isPost())
            return $this->_helper->redirector('index', 'index');
        
        $deliveryForm = DeliveryFormTable::getInstance()->find($this->getRequest()->getParam(FieldIdEnum::DELIVERY_FORM_ID));
        
        $form = new Auctions_Form_DeliveryForm_Add($deliveryForm);
        if (!$form->isValid($request->getPost()))
        {
            $this->view->form = $form;
            return $this->render('fill');
        }
        
        if ($deliveryForm->stage !== Enum_Db_DeliveryForm_Stage::TO_FILL)
        {
            $this->view->form = $form;
            $form->setDescription($this->_getTranslator()->translate('validation_message-delivery_form_already_filled'));
            return $this->render('fill');
        }
        
        try {
            Doctrine_Manager::connection()->beginTransaction();
            
            $deliveryForm->address_id = $form->getValue(FieldIdEnum::DELIVERY_FORM_ADDRESS_ID);
            $deliveryForm->delivery_id = $form->getValue(FieldIdEnum::DELIVERY_FORM_DELIVERY_ID);
            $deliveryForm->comment = $form->getValue(FieldIdEnum::DELIVERY_FORM_COMMENT);
            $deliveryForm->stage = Enum_Db_DeliveryForm_Stage::TO_PROCESS;
            $deliveryForm->save();
            
            $notificationSender = new Notification_Sender();
            $notificationSender->send($deliveryForm, Enum_Db_Notification_Type::DELIVERY_FROM_FILLED_AUCTION_OWNER);
            
            Doctrine_Manager::connection()->commit();
        }
        catch (Exception $ex)
        {
            Doctrine_Manager::connection()->rollback();
            Log_Factory::create($ex, Zend_Log::CRIT);
            $this->view->form = $form;
            $form->setDescription('Failure!');
            return $this->render('fill');
        }
        
        $this->_helper->redirector('index', 'index');
    }
}
