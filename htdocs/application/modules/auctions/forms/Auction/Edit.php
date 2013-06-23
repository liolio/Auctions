<?php
/**
 * @class Auctions_Form_Auction_Edit
 */
class Auctions_Form_Auction_Edit extends Auctions_Form_Abstract
{
    
    public function __construct($options = array())
    {
        $formOptions = array_merge(
            array(
                'action' => '/auction/process-edit-form',
                'method' => 'post',
                'id'     => 'fullPage'
            ), $options
        );
        
        parent::__construct($formOptions);
    }
    
    public function init()
    {
        $id = new Zend_Form_Element_Hidden(FieldIdEnum::AUCTION_ID);
        $id->setRequired()
            ->addValidator(new Zend_Validate_Int());
        
        $title = new Form_Element_Text(FieldIdEnum::AUCTION_TITLE);
        $title->setRequired()
                ->addValidator(new Validate_StringLength(array('min' => 1, 'max' => 100)))
                ->setLabel($this->_getTranslator()->translate('label-auction_title'));
                
        $editor = new Form_Element_Textarea(ParamIdEnum::CKEDITOR, false);
        $editor->setRequired()
                ->setLabel($this->_getTranslator()->translate('label-auction_description'));
        
        $editButton = new Zend_Form_Element_Submit(ParamIdEnum::FORM_EDIT_BUTTON);
        $editButton->setIgnore(true);
        
        $this->addElements(array($id, $title, $editor, $editButton));
        
        $this->setDecorators(array(
            'FormElements',
            array('HtmlTag', array('tag' => 'dl', 'class' => 'zend_form')),
            array('Description', array('placement' => 'prepend')),
            'Form'
        ));
    }
    
}
