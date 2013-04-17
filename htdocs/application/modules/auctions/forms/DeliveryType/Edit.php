<?php
/**
 * @class Auctions_Form_DeliveryType_Edit
 */
class Auctions_Form_DeliveryType_Edit extends Auctions_Form_DeliveryType_Abstract
{
    
    public function __construct($options = array())
    {
        $formOptions = array_merge(
            array(
                'action' => '/delivery-type/process-edit-form',
                'method' => 'post',
            ), $options
        );
        
        parent::__construct($formOptions);
    }
    
    public function init()
    {
        $id = new Zend_Form_Element_Hidden(FieldIdEnum::DELIVERY_TYPE_ID);
        $id->setRequired()
            ->addValidator(new Zend_Validate_Int());
        $this->addElement($id);
        
        parent::init();
    }
    
    protected function _getSubmitButton()
    {
        $editButton = new Zend_Form_Element_Submit(ParamIdEnum::FORM_EDIT_BUTTON);
        $editButton->setIgnore(true);
        
        return $editButton;
    }
    
}
