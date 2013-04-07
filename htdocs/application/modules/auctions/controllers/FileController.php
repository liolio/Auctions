<?php
/**
 * @class Auctions_FileController
 */
class Auctions_FileController extends Zend_Controller_Action
{

    public function init()
    {
        Zend_Layout::startMvc();
    }

    public function addAction()
    {
        $this->view->addForm = new Auctions_Form_File_Add();
    }
    
    public function processAddFormAction()
    {
        $request = $this->getRequest();

        
        if (!$request->isPost())
            return $this->_helper->redirector('add');
        
        $form = new Auctions_Form_File_Add();
        if (!$form->isValid($request->getPost()))
        {
            $this->view->addForm = $form;
            return $this->render('add');
        }
        
        
        $fileElement = $form->getElement(ParamIdEnum::FILE);
        
        $originalFilename = pathinfo($fileElement->getFileName());
        $fileInfo = $fileElement->getFileInfo();
        $newFilename = 'file-' . uniqid() . '.' . $originalFilename['extension'];
        
        $fileElement->addFilter('Rename', $newFilename);
        $fileElement->receive();

        
        
        try {
            Doctrine_Manager::connection()->beginTransaction();
            File_Factory::create(array(
                FieldIdEnum::FILE_FILENAME          =>  $newFilename,
                FieldIdEnum::FILE_ORIGINAL_FILENAME =>  $originalFilename['basename'],
                FieldIdEnum::FILE_MIME_TYPE         =>  $fileElement->getMimeType(),
                FieldIdEnum::FILE_SIZE              =>  $fileInfo[ParamIdEnum::FILE]['size'],
            ), Auth_User::getInstance()->getUser())->save();
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
        
        $this->_helper->redirector('add', 'file');
    }
}
