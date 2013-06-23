<?php
/**
 * @class Auctions_BankingInformationController
 */
class Auctions_BankingInformationController extends Controller_Abstract
{
    
    public function showListAction()
    {
        $this->view->list = Auth_User::getInstance()->getUser()->BankingInformations;
        $this->view->listCount = count($this->view->list);
    }
    
    public function addAction()
    {
        $this->view->addForm = new Auctions_Form_BankingInformation_Add();
    }
    
    public function processAddFormAction()
    {
        $request = $this->getRequest();

        if (!$request->isPost())
            return $this->_helper->redirector('add');
        
        $form = new Auctions_Form_BankingInformation_Add();
        if (!$form->isValid($request->getPost()))
        {
            $this->view->addForm = $form;
            return $this->render('add');
        }
        
        try {
            Doctrine_Manager::connection()->beginTransaction();
            BankingInformation_Factory::create(
                array(
                    FieldIdEnum::BANKING_INFORMATION_BANK_NAME      =>  $form->getValue(FieldIdEnum::BANKING_INFORMATION_BANK_NAME),
                    FieldIdEnum::BANKING_INFORMATION_ACCOUNT_NUMBER =>  $form->getValue(FieldIdEnum::BANKING_INFORMATION_ACCOUNT_NUMBER),
                ),
                CurrencyTable::getInstance()->find($form->getValue(FieldIdEnum::BANKING_INFORMATION_CURRENCY_ID)),
                Auth_User::getInstance()->getUser()
            )->save();
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
        
        $this->_helper->redirector('show-list', 'banking-information');
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

            $bankingInformation = BankingInformationTable::getInstance()->find($request->getParam(FieldIdEnum::BANKING_INFORMATION_ID));
            $bankingInformation->bank_name = $form->getValue(FieldIdEnum::BANKING_INFORMATION_BANK_NAME);
            $bankingInformation->account_number = $form->getValue(FieldIdEnum::BANKING_INFORMATION_ACCOUNT_NUMBER);
            $bankingInformation->currency_id = $form->getValue(FieldIdEnum::BANKING_INFORMATION_CURRENCY_ID);
            
            $bankingInformation->save();
            
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
        
        $this->_helper->redirector('show-list', 'banking-information');
    }
    
    public function deleteAction()
    {
        try {
            Doctrine_Manager::connection()->beginTransaction();
            BankingInformationTable::getInstance()->findOneBy('id', $this->getRequest()->getParam(FieldIdEnum::BANKING_INFORMATION_ID))->delete();
            Doctrine_Manager::connection()->commit();
        }
        catch (Exception $ex)
        {
            Doctrine_Manager::connection()->rollback();
            Log_Factory::create($ex, Zend_Log::CRIT);
        }
        
        $this->_helper->redirector('show-list', 'banking-information');
    }
    
    private function _getFilledEditForm()
    {
        $bankingInformationId = $this->getRequest()->getParam(FieldIdEnum::BANKING_INFORMATION_ID);
        
        $form = new Auctions_Form_BankingInformation_Edit();
        
        if (!is_null($bankingInformationId))
        {
            $bankingInformation = BankingInformationTable::getInstance()->find($bankingInformationId);
            
            if ($bankingInformation !== false)
            {
                $form->getElement(FieldIdEnum::BANKING_INFORMATION_ID)->setValue($bankingInformationId);
                $form->getElement(FieldIdEnum::BANKING_INFORMATION_BANK_NAME)->setValue($bankingInformation->bank_name);
                $form->getElement(FieldIdEnum::BANKING_INFORMATION_ACCOUNT_NUMBER)->setValue($bankingInformation->account_number);
                $form->getElement(FieldIdEnum::BANKING_INFORMATION_CURRENCY_ID)->setValue($bankingInformation->currency_id);
            }
        }
        
        return $form;
    }
    
}
