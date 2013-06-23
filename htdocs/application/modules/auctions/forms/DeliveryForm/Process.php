<?php
/**
 * @class Auctions_Form_DeliveryForm_Process
 */
class Auctions_Form_DeliveryForm_Process extends Auctions_Form_Abstract
{
    
    public function __construct($options = array())
    {
        $formOptions = array_merge(
            array(
                'action' => '/delivery-form/process-process-form',
                'method' => 'post',
            ), $options
        );
        
        parent::__construct($formOptions);
    }
    
    public function init()
    {
        $id = new Zend_Form_Element_Hidden(FieldIdEnum::DELIVERY_FORM_ID);
        $id->setRequired()
            ->addValidator(new Zend_Validate_Int());
        
        $isProcessed = new Zend_Form_Element_Checkbox(ParamIdEnum::DELIVERY_FORM_IS_PROCESSED);
        $isProcessed->setRequired()
                ->setLabel($this->_getTranslator()->translate('label-delivery_form_is_processed'));
        
        $saveButton = new Zend_Form_Element_Submit(ParamIdEnum::FORM_SAVE_BUTTON);
        $saveButton->setIgnore(true);
        
        $this->addElements(array($isProcessed, $id, $saveButton));
        
        $this->setDecorators(array(
            'FormElements',
            array('HtmlTag', array('tag' => 'dl', 'class' => 'zend_form')),
            array('Description', array('placement' => 'prepend')),
            'Form'
        ));
    }
    
}
