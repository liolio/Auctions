<?php
/**
 * @class Auctions_Form_File_Add
 */
class Auctions_Form_File_Add extends Auctions_Form_Abstract
{
    
    public function __construct($options = array())
    {
        $formOptions = array_merge(
            array(
                'action' => '/file/process-add-form',
                'method' => 'post',
            ), $options
        );
        
        parent::__construct($formOptions);
    }
    
    public function init()
    {
        $file = new Form_Element_File(ParamIdEnum::FILE);
        $file->setRequired()
            ->setDestination(APPLICATION_PATH . '/../public/uploads');
        
        $addButton = new Zend_Form_Element_Submit(ParamIdEnum::FORM_ADD_BUTTON);
        $addButton->setIgnore(true);
        
        $this->addElements(array($file, $addButton));
        
        $this->setDecorators(array(
            'FormElements',
            array('HtmlTag', array('tag' => 'dl', 'class' => 'zend_form')),
            array('Description', array('placement' => 'prepend')),
            'Form'
        ));
    }
    
}
