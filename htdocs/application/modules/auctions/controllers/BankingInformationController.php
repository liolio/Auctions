<?php
/**
 * @class Auctions_BankingInformationController
 */
class Auctions_BankingInformationController extends Controller_Abstract
{
    
    public function init()
    {
        Zend_Layout::startMvc();
    }
    
    public function showListAction()
    {
        $this->view->list = Auth_User::getInstance()->getUser()->BankingInformations;
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
    
}
