<?php
/**
 * @class Auctions_CategoryController
 */
class Auctions_CategoryController extends Controller_Abstract
{
    
    public function init()
    {
        Zend_Layout::startMvc();
    }
    
    public function showAdministratorListAction()
    {
        $this->view->mainCategories = CategoryTable::getInstance()->getCategoriesList();
    }
    
    public function addAction()
    {
        $this->view->addForm = new Auctions_Form_Category_Add();
    }
    
    public function processAddFormAction()
    {
         $request = $this->getRequest();

        if (!$request->isPost())
            return $this->_helper->redirector('add');
        
        $form = new Auctions_Form_Category_Add();
        if (!$form->isValid($request->getPost()))
        {
            $this->view->addForm = $form;
            return $this->render('add');
        }
        
        try {
            Doctrine_Manager::connection()->beginTransaction();
            Category_Factory::create(array(
                FieldIdEnum::CATEGORY_NAME                  =>  $form->getValue(FieldIdEnum::CATEGORY_NAME),
                FieldIdEnum::CATEGORY_DESCRIPTION           =>  $form->getValue(FieldIdEnum::CATEGORY_DESCRIPTION),
                FieldIdEnum::CATEGORY_PARENT_CATEGORY_ID    =>  $form->getValue(FieldIdEnum::CATEGORY_PARENT_CATEGORY_ID)
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
        
        $this->_helper->redirector('show-administrator-list', 'category');
    }
    
}
