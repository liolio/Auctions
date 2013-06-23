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
    
    public function showListAction()
    {
        $this->view->toProcess = DeliveryFormTable::getInstance()->getFormsForUserAndStage(Auth_User::getInstance()->getUser(), Enum_Db_DeliveryForm_Stage::TO_PROCESS);
        $this->view->processed = DeliveryFormTable::getInstance()->getFormsForUserAndStage(Auth_User::getInstance()->getUser(), Enum_Db_DeliveryForm_Stage::PROCESSED);
    }
    
    public function processAction()
    {
        $deliveryFormId = $this->getRequest()->getParam(FieldIdEnum::DELIVERY_FORM_ID);
        
        $this->view->deliveryForm = DeliveryFormTable::getInstance()->find($deliveryFormId);
        $this->view->deliveryFormComment = $this->_formatToHtml($this->view->deliveryForm->comment);
        
        $this->view->form = new Auctions_Form_DeliveryForm_Process();
        $this->view->form->getElement(FieldIdEnum::DELIVERY_FORM_ID)->setValue($deliveryFormId);
        $this->view->form->getElement(ParamIdEnum::DELIVERY_FORM_IS_PROCESSED)->setValue($this->view->deliveryForm->stage === Enum_Db_DeliveryForm_Stage::PROCESSED);
    }
    
    public function processProcessFormAction()
    {
        $request = $this->getRequest();
        
        if (!$request->isPost())
            return $this->_helper->redirector('index', 'index');
        
        $form = new Auctions_Form_DeliveryForm_Process();
        if (!$form->isValid($request->getPost()))
        {
            $this->processAction();
            return $this->render('process');
        }
        
        try {
            Doctrine_Manager::connection()->beginTransaction();
            
            $deliveryForm = DeliveryFormTable::getInstance()->find($form->getValue(FieldIdEnum::DELIVERY_FORM_ID));
            $deliveryForm->stage = $form->getValue(ParamIdEnum::DELIVERY_FORM_IS_PROCESSED) ? Enum_Db_DeliveryForm_Stage::PROCESSED : Enum_Db_DeliveryForm_Stage::TO_PROCESS;
            $deliveryForm->save();
            
            Doctrine_Manager::connection()->commit();
        }
        catch (Exception $ex)
        {
            Doctrine_Manager::connection()->rollback();
            Log_Factory::create($ex, Zend_Log::CRIT);
            $this->processAction();
            $this->view->form->setDescription('Failure!');
            return $this->render('process');
            
        }
        
        $this->_helper->redirector('show-list', 'delivery-form');
    }
    
    private function _formatToHtml($value)
    {
        return str_replace(
            array(
                '\n',
                '
',
                '\t'
            ), 
            array(
                '<br/>',
                '<br/>',
                '&nbsp;&nbsp;&nbsp;&nbsp;'
            ), 
            $value);
        
    }
}
