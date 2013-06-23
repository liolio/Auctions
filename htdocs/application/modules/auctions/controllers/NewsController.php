<?php
/**
 * @class Auctions_NewsController
 */
class Auctions_NewsController extends Controller_Abstract
{
    
    public function showListAction()
    {
        $this->view->newses = NewsTable::getInstance()->createQuery()
                ->orderBy('created_at DESC')
                ->execute();
        $this->view->newsesCount = count($this->view->newses);
    }
    
     public function addAction()
    {
        $this->view->addForm = new Auctions_Form_News_Add();
    }
    
    public function processAddFormAction()
    {
        $request = $this->getRequest();

        if (!$request->isPost())
            return $this->_helper->redirector('add');
        
        $form = new Auctions_Form_News_Add();
        if (!$form->isValid($request->getPost()))
        {
            $this->view->addForm = $form;
            return $this->render('add');
        }
        
        try {
            Doctrine_Manager::connection()->beginTransaction();
            News_Factory::create(Auth_User::getInstance()->getUser(), array(
                FieldIdEnum::NEWS_TITLE         =>  $form->getValue(FieldIdEnum::NEWS_TITLE),
                FieldIdEnum::NEWS_DESCRIPTION   =>  $form->getValue(FieldIdEnum::NEWS_DESCRIPTION),
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
        
        $this->_helper->redirector('show-list', 'news');
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

            $news = NewsTable::getInstance()->find($request->getParam(FieldIdEnum::NEWS_ID));
            $news->title = $form->getValue(FieldIdEnum::NEWS_TITLE);
            $news->description = $form->getValue(FieldIdEnum::NEWS_DESCRIPTION);
            $news->User = Auth_User::getInstance()->getUser();
            
            $news->save();
            
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
        
        $this->_helper->redirector('show-list', 'news');
    }
    
    public function deleteAction()
    {
        try {
            Doctrine_Manager::connection()->beginTransaction();
            NewsTable::getInstance()->findOneBy('id', $this->getRequest()->getParam(FieldIdEnum::NEWS_ID))->delete();
            Doctrine_Manager::connection()->commit();
        }
        catch (Exception $ex)
        {
            Doctrine_Manager::connection()->rollback();
            Log_Factory::create($ex, Zend_Log::CRIT);
        }
        
        $this->_helper->redirector('show-list', 'news');
    }
    
    private function _getFilledEditForm()
    {
        $newsId = $this->getRequest()->getParam(FieldIdEnum::NEWS_ID);
        
        $form = new Auctions_Form_News_Edit();
        
        if (!is_null($newsId))
        {
            $news = NewsTable::getInstance()->find($newsId);
            
            if ($news !== false)
            {
                $form->getElement(FieldIdEnum::NEWS_ID)->setValue($newsId);
                $form->getElement(FieldIdEnum::NEWS_TITLE)->setValue($news->title);
                $form->getElement(FieldIdEnum::NEWS_DESCRIPTION)->setValue($news->description);
            }
        }
        
        return $form;
    }
}
