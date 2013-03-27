<?php
/**
 * @class Auctions_CurrencyController
 */
class Auctions_CurrencyController extends Controller_Abstract
{
    
    public function init()
    {
        Zend_Layout::startMvc();
    }
    
    public function showAdministratorListAction()
    {
        $this->view->list = CurrencyTable::getInstance()->createQuery()->orderBy("name ASC")->execute();
    }
    
    public function addAction()
    {
        $this->view->addForm = new Auctions_Form_Currency_Add();
    }
    
    public function processAddFormAction()
    {
         $request = $this->getRequest();

        if (!$request->isPost())
            return $this->_helper->redirector('add');
        
        $form = new Auctions_Form_Currency_Add();
        if (!$form->isValid($request->getPost()))
        {
            $this->view->addForm = $form;
            return $this->render('add');
        }
        
        try {
            Doctrine_Manager::connection()->beginTransaction();
            Currency_Factory::create(array(
                FieldIdEnum::CURRENCY_NAME  =>  $form->getValue(FieldIdEnum::CURRENCY_NAME),
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
        
        $this->_helper->redirector('show-administrator-list', 'currency');
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

            $currency = CurrencyTable::getInstance()->find($request->getParam(FieldIdEnum::CURRENCY_ID));
            $currency->name = $form->getValue(FieldIdEnum::CURRENCY_NAME);
            
            $currency->save();
            
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
        
        $this->_helper->redirector('show-administrator-list', 'currency');
    }
    
    public function deleteAction()
    {
        $currencyId = $this->getRequest()->getParam(FieldIdEnum::CURRENCY_ID);
        
        if (BankingInformationTable::getInstance()->findBy("currency_id", $currencyId)->count() > 0)
        {
            $this->showAdministratorListAction();
            $this->view->message = Helper::getTranslator()->translate("validation_message-cannot_delete_currency_has_banking_informations");
            return $this->render("show-administrator-list");
        }
        
        try {
            Doctrine_Manager::connection()->beginTransaction();
            CurrencyTable::getInstance()->findOneBy('id', $currencyId)->delete();
            Doctrine_Manager::connection()->commit();
        }
        catch (Exception $ex)
        {
            Doctrine_Manager::connection()->rollback();
            Log_Factory::create($ex, Zend_Log::CRIT);
        }
        
        $this->_helper->redirector('show-administrator-list', 'currency');
    }
    
    private function _getFilledEditForm()
    {
        $currencyId = $this->getRequest()->getParam(FieldIdEnum::CURRENCY_ID);
        
        $form = new Auctions_Form_Currency_Edit();
        
        if (!is_null($currencyId))
        {
            $currency = CurrencyTable::getInstance()->find($currencyId);
            
            if ($currency !== false)
            {
                $form->getElement(FieldIdEnum::CURRENCY_ID)->setValue($currencyId);
                $form->getElement(FieldIdEnum::CURRENCY_NAME)->setValue($currency->name);
            }
        }
        
        return $form;
    }
    
}
