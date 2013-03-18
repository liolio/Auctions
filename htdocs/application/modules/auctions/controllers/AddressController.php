<?php
/**
 * @class Auctions_AddressController
 */
class Auctions_AddressController extends Zend_Controller_Action
{
    
    public function init()
    {
        Zend_Layout::startMvc();
    }
    
    public function showListAction()
    {
        $this->view->addressList = Auth_User::getInstance()->getUser()->Addresses;
    }
    
    public function addAction()
    {
        $this->view->addForm = new Auctions_Form_Address_Add();
    }
    
    public function processAddFormAction()
    {
        $request = $this->getRequest();

        if (!$request->isPost())
            return $this->_helper->redirector('add');
        
        $form = new Auctions_Form_Address_Add();
        if (!$form->isValid($request->getPost()))
        {
            $this->view->addForm = $form;
            return $this->render('add');
        }
        
        try {
            Doctrine_Manager::connection()->beginTransaction();
            Address_Factory::create(Auth_User::getInstance()->getUser(), array(
                FieldIdEnum::ADDRESS_NAME           =>  $form->getValue(FieldIdEnum::ADDRESS_NAME),
                FieldIdEnum::ADDRESS_SURNAME        =>  $form->getValue(FieldIdEnum::ADDRESS_SURNAME),
                FieldIdEnum::ADDRESS_STREET         =>  $form->getValue(FieldIdEnum::ADDRESS_STREET),
                FieldIdEnum::ADDRESS_POSTAL_CODE    =>  $form->getValue(FieldIdEnum::ADDRESS_POSTAL_CODE),
                FieldIdEnum::ADDRESS_CITY           =>  $form->getValue(FieldIdEnum::ADDRESS_CITY),
                FieldIdEnum::ADDRESS_COUNTRY        =>  $form->getValue(FieldIdEnum::ADDRESS_COUNTRY),
                FieldIdEnum::ADDRESS_PHONE_NUMBER   =>  $form->getValue(FieldIdEnum::ADDRESS_PHONE_NUMBER),
                FieldIdEnum::ADDRESS_PROVINCE       =>  $form->getValue(FieldIdEnum::ADDRESS_PROVINCE)
            ))->save();
            
            Doctrine_Manager::connection()->commit();
        }
        catch (Exception $ex)
        {
            Doctrine_Manager::connection()->rollback();
            Log_Factory::create($ex, Zend_Log::CRIT);
            $this->view->registrationForm = $form;
            $form->setDescription('Failure!');
            return $this->render('add');
        }
        
        $this->_helper->redirector('show-list', 'address');
    }
    
    public function deleteAction()
    {
        if (Auth_User::getInstance()->getUser()->Addresses->count() === 1) 
        {
            $this->view->addressList = Auth_User::getInstance()->getUser()->Addresses;
            $this->view->message = Helper::getTranslator()->translate("validation_message-address_cannot_remove_last_address");
            return $this->render("showList");
        }
        
        try {
            Doctrine_Manager::connection()->beginTransaction();
            AddressTable::getInstance()->findOneBy('id', $this->getRequest()->getParam(FieldIdEnum::ADDRESS_ID))->delete();
            Doctrine_Manager::connection()->commit();
        }
        catch (Exception $ex)
        {
            Doctrine_Manager::connection()->rollback();
            Log_Factory::create($ex, Zend_Log::CRIT);
        }
        
        $this->_helper->redirector('show-list', 'address');
    }
}
