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
            $this->view->editForm = $form;
            $form->setDescription('Failure!');
            return $this->render('add');
        }
        
        $this->_helper->redirector('show-list', 'address');
    }
    
    public function editAction()
    {
        $this->view->editForm = $this->_getFilledEditForm();
    }
    
    public function processEditFormAction()
    {
        $request = $this->getRequest();

        if (!$request->isPost())
            return $this->_helper->redirector('edit');
        
        $form = new Auctions_Form_Address_Edit();
        if (!$form->isValid($request->getPost()))
        {
            $this->view->editForm = $form;
            return $this->render('edit');
        }
        
        try {
            Doctrine_Manager::connection()->beginTransaction();
            
            $address = AddressTable::getInstance()->find($request->getParam(FieldIdEnum::ADDRESS_ID));
            
            if ($address !== false)
            {
                $address->name = $request->getParam(FieldIdEnum::ADDRESS_NAME);
                $address->surname = $request->getParam(FieldIdEnum::ADDRESS_SURNAME);
                $address->street = $request->getParam(FieldIdEnum::ADDRESS_STREET);
                $address->postal_code = $request->getParam(FieldIdEnum::ADDRESS_POSTAL_CODE);
                $address->city = $request->getParam(FieldIdEnum::ADDRESS_CITY);
                $address->country = $request->getParam(FieldIdEnum::ADDRESS_COUNTRY);
                $address->phone_number = $request->getParam(FieldIdEnum::ADDRESS_PHONE_NUMBER);
                $address->province = $request->getParam(FieldIdEnum::ADDRESS_PROVINCE);
                
                $address->save();
            }
            
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
        
        $this->_helper->redirector('show-list', 'address');
    }

    public function deleteAction()
    {
        if (AddressTable::getInstance()->findBy("user_id", Auth_User::getInstance()->getUser()->id)->count() === 1) 
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
    
    /**
     * Used to get edit form with filled data.
     * 
     * @return Auctions_Form_Address_Edit
     */
    private function _getFilledEditForm()
    {
        $addressId = $this->getRequest()->getParam(FieldIdEnum::ADDRESS_ID);
        
        $form = new Auctions_Form_Address_Edit();
        
        if (!is_null($addressId))
        {
            $address = AddressTable::getInstance()->find($addressId);
            
            if ($address !== false)
            {
                $form->getElement(FieldIdEnum::ADDRESS_ID)->setValue($addressId);
                $form->getElement(FieldIdEnum::ADDRESS_NAME)->setValue($address->name);
                $form->getElement(FieldIdEnum::ADDRESS_SURNAME)->setValue($address->surname);
                $form->getElement(FieldIdEnum::ADDRESS_STREET)->setValue($address->street);
                $form->getElement(FieldIdEnum::ADDRESS_POSTAL_CODE)->setValue($address->postal_code);
                $form->getElement(FieldIdEnum::ADDRESS_CITY)->setValue($address->city);
                $form->getElement(FieldIdEnum::ADDRESS_COUNTRY)->setValue($address->country);
                $form->getElement(FieldIdEnum::ADDRESS_PHONE_NUMBER)->setValue($address->phone_number);
                $form->getElement(FieldIdEnum::ADDRESS_PROVINCE)->setValue($address->province);
            }
        }
        
        return $form;
    }
}
