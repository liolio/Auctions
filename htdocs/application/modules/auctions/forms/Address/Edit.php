<?php
/**
 * @class Auctions_Form_Address_Edit
 */
class Auctions_Form_Address_Edit extends Auctions_Form_Abstract
{
    
    public function __construct($options = array())
    {
        $formOptions = array_merge(
            array(
                'action' => '/address/process-edit-form',
                'method' => 'post',
            ), $options
        );
        
        parent::__construct($formOptions);
    }
    
    public function init()
    {
        $id = new Zend_Form_Element_Hidden(FieldIdEnum::ADDRESS_ID);
        $id->setRequired()
            ->addValidator(new Zend_Validate_Int());
        $this->addElement($id);
        
        $formElements = new Form_Elements_Address();
        $this->addElements($formElements->getElements());
        
        $addButton = new Zend_Form_Element_Submit(ParamIdEnum::SUBMIT_BUTTON);
        $addButton->setIgnore(true)
                ->setLabel($this->_getTranslator()->translate('caption-edit'));
        
        $this->addElement($addButton);
        
        $this->setDecorators(array(
            'FormElements',
            array('HtmlTag', array('tag' => 'dl', 'class' => 'zend_form')),
            array('Description', array('placement' => 'prepend')),
            'Form'
        ));
    }
    
}
