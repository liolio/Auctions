<?php
/**
 * @class Auctions_Form_Currency_Edit
 */
class Auctions_Form_Currency_Edit extends Auctions_Form_Currency_Abstract
{
    
    public function __construct($options = array())
    {
        $formOptions = array_merge(
            array(
                'action' => '/currency/process-edit-form',
                'method' => 'post',
            ), $options
        );
        
        parent::__construct($formOptions);
    }
    
    public function init()
    {
        $id = new Zend_Form_Element_Hidden(FieldIdEnum::CURRENCY_ID);
        $id->setRequired()
            ->addValidator(new Zend_Validate_Int());
        $this->addElement($id);
        
        parent::init();
    }
    
    protected function _getSubmitButton()
    {
        $addButton = new Zend_Form_Element_Submit(ParamIdEnum::FORM_EDIT_BUTTON);
        $addButton->setIgnore(true);
        
        return $addButton;
    }
    
}
