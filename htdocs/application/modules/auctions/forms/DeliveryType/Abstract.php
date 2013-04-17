<?php
/**
 * @class Auctions_Form_DeliveryType_Abstract
 */
abstract class Auctions_Form_DeliveryType_Abstract extends Auctions_Form_Abstract
{
    
     public function init()
    {
        $name = new Form_Element_Text(FieldIdEnum::DELIVERY_TYPE_NAME);
        $name->setRequired()
                ->setLabel($this->_getTranslator()->translate('label-delivery_type_name'))
                ->addValidator(new Validate_StringLength(array('min' => 1, 'max' => 100)))
                ->addValidator(new Validate_DeliveryType_Unique());
        
        $cashOnDelivery = new Zend_Form_Element_Checkbox(FieldIdEnum::DELIVERY_TYPE_CASH_ON_DELIVERY);
        $cashOnDelivery->setRequired()
                ->setLabel($this->_getTranslator()->translate('label-delivery_type_cash_on_demand'));
        
        $this->addElements(array($name, $cashOnDelivery, $this->_getSubmitButton()));
        
        $this->setDecorators(array(
            'FormElements',
            array('HtmlTag', array('tag' => 'dl', 'class' => 'zend_form')),
            array('Description', array('placement' => 'prepend')),
            'Form'
        ));
    }
    
    abstract protected function _getSubmitButton();
    
}
