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

            $category = CategoryTable::getInstance()->find($request->getParam(FieldIdEnum::CATEGORY_ID));
            $category->name = $form->getValue(FieldIdEnum::CATEGORY_NAME);
            $category->description = $form->getValue(FieldIdEnum::CATEGORY_DESCRIPTION);
            $parentCategoryId = $form->getValue(FieldIdEnum::CATEGORY_PARENT_CATEGORY_ID);
            $category->parent_category_id = empty($parentCategoryId) ? null : $parentCategoryId;
            
            $category->save();
            
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
        
        $this->_helper->redirector('show-administrator-list', 'category');
    }
    
    public function deleteAction()
    {
        $categoryId = $this->getRequest()->getParam(FieldIdEnum::CATEGORY_ID);
        if (CategoryTable::getInstance()->findBy("parent_category_id", $categoryId)->count() > 0) 
        {
            $this->showAdministratorListAction();
            $this->view->message = Helper::getTranslator()->translate("validation_message-cannot_delete_category_has_subcategories");
            return $this->render("show-administrator-list");
        }
        
        try {
            Doctrine_Manager::connection()->beginTransaction();
            CategoryTable::getInstance()->findOneBy('id', $this->getRequest()->getParam(FieldIdEnum::CATEGORY_ID))->delete();
            Doctrine_Manager::connection()->commit();
        }
        catch (Exception $ex)
        {
            Doctrine_Manager::connection()->rollback();
            Log_Factory::create($ex, Zend_Log::CRIT);
        }
        
        $this->_helper->redirector('show-administrator-list', 'category');
    }
    
    
    private function _getFilledEditForm()
    {
        $categoryId = $this->getRequest()->getParam(FieldIdEnum::CATEGORY_ID);
        
        $form = new Auctions_Form_Category_Edit(array(ParamIdEnum::CATEGORY_WITHOUT_CATEGORY_ID =>  $categoryId));
        
        if (!is_null($categoryId))
        {
            $category = CategoryTable::getInstance()->find($categoryId);
            
            if ($category !== false)
            {
                $form->getElement(FieldIdEnum::CATEGORY_ID)->setValue($categoryId);
                $form->getElement(FieldIdEnum::CATEGORY_NAME)->setValue($category->name);
                $form->getElement(FieldIdEnum::CATEGORY_DESCRIPTION)->setValue($category->description);
                $form->getElement(FieldIdEnum::CATEGORY_PARENT_CATEGORY_ID)->setValue($category->parent_category_id);
            }
        }
        
        return $form;
    }
}
