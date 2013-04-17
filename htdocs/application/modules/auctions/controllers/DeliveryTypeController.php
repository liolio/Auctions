<?php
/**
 * @class Auctions_DeliveryTypeController
 */
class Auctions_DeliveryTypeController extends Controller_Abstract
{
    
    public function init()
    {
        Zend_Layout::startMvc();
    }
    
    public function showAdministratorListAction()
    {
        $this->view->deliveryTypes = DeliveryTypeTable::getInstance()->findAll();
    }
    
    public function addAction()
    {
        $this->view->addForm = new Auctions_Form_DeliveryType_Add();
    }
    
    public function processAddFormAction()
    {
        $request = $this->getRequest();

        if (!$request->isPost())
            return $this->_helper->redirector('add');
        
        $form = new Auctions_Form_DeliveryType_Add();
        if (!$form->isValid($request->getPost()))
        {
            $this->view->addForm = $form;
            return $this->render('add');
        }
        
        try {
            Doctrine_Manager::connection()->beginTransaction();
            DeliveryType_Factory::create(array(
                FieldIdEnum::DELIVERY_TYPE_NAME             =>  $form->getValue(FieldIdEnum::DELIVERY_TYPE_NAME),
                FieldIdEnum::DELIVERY_TYPE_CASH_ON_DELIVERY =>  $form->getValue(FieldIdEnum::DELIVERY_TYPE_CASH_ON_DELIVERY),
            ))->save();
            Doctrine_Manager::connection()->commit();
        }
        catch (Exception $ex)
        {
            Doctrine_Manager::connection()->rollback();
            Log_Factory::create($ex, Zend_Log::CRIT);
            $this->view->addForm = $form;
            $form->setDescription('Failure!');
            return $this->render('add');
        }
        
        $this->_helper->redirector('show-administrator-list', 'delivery-type');
    }
    
    public function editAction()
    {
        $this->view->editForm = $this->_getFilledEditForm();
    }
    
    public function processEditFormAction()
    {
         $request = $this->getRequest();

        if (!$request->isPost())
            return $this->_helper->redirector('show-administrator-list');
        
        $form = $this->_getFilledEditForm();
        if (!$form->isValid($request->getPost()))
        {
            $this->view->editForm = $form;
            return $this->render('edit');
        }
        
        try {
            Doctrine_Manager::connection()->beginTransaction();

            $deliveryType = DeliveryTypeTable::getInstance()->find($request->getParam(FieldIdEnum::DELIVERY_TYPE_ID));
            $deliveryType->name = $form->getValue(FieldIdEnum::DELIVERY_TYPE_NAME);
            $deliveryType->cash_on_delivery = $form->getValue(FieldIdEnum::DELIVERY_TYPE_CASH_ON_DELIVERY);
            
            $deliveryType->save();
            
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
        
        $this->_helper->redirector('show-administrator-list', 'delivery-type');
    }
    
    public function deleteAction()
    {
        $deliveryTypeId = $this->getRequest()->getParam(FieldIdEnum::DELIVERY_TYPE_ID);
        if (DeliveryTable::getInstance()->findBy("delivery_type_id", $deliveryTypeId)->count() > 0) 
        {
            $this->showAdministratorListAction();
            $this->view->message = Helper::getTranslator()->translate("validation_message-cannot_delete_delivery_type_has_deliveries");
            return $this->render("show-administrator-list");
        }
        
        try {
            Doctrine_Manager::connection()->beginTransaction();
            DeliveryTypeTable::getInstance()->find($deliveryTypeId)->delete();
            Doctrine_Manager::connection()->commit();
        }
        catch (Exception $ex)
        {
            Doctrine_Manager::connection()->rollback();
            Log_Factory::create($ex, Zend_Log::CRIT);
        }
        
        $this->_helper->redirector('show-administrator-list', 'delivery-type');
    }
    
    private function _getFilledEditForm()
    {
        $deliveryTypeId = $this->getRequest()->getParam(FieldIdEnum::DELIVERY_TYPE_ID);
        
        $form = new Auctions_Form_DeliveryType_Edit();
        
        if (!is_null($deliveryTypeId))
        {
            $deliveryType = DeliveryTypeTable::getInstance()->find($deliveryTypeId);
            
            if ($deliveryType !== false)
            {
                $form->getElement(FieldIdEnum::DELIVERY_TYPE_ID)->setValue($deliveryTypeId);
                $form->getElement(FieldIdEnum::DELIVERY_TYPE_NAME)->setValue($deliveryType->name);
                $form->getElement(FieldIdEnum::DELIVERY_TYPE_CASH_ON_DELIVERY)->setValue($deliveryType->cash_on_delivery);
            }
        }
        
        return $form;
    }
}
