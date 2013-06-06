<?php
/**
 * @class Auctions_Form_DeliveryForm_Add
 */
class Auctions_Form_DeliveryForm_Add extends Auctions_Form_Abstract
{
    
    /**
     * @var DeliveryForm
     */
    private $_deliveryForm;
    
    public function __construct(DeliveryForm $deliveryForm, $options = array())
    {
        $this->_deliveryForm = $deliveryForm;
        
        $formOptions = array_merge(
            array(
                'action' => '/delivery-form/process-add-form',
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
        $id->setValue($this->_deliveryForm->id);
        
        $address = new Form_Element_Radio(FieldIdEnum::DELIVERY_FORM_ADDRESS_ID);
        $address->setRequired()
            ->setLabel($this->_getTranslator()->translate('label-delivery_form_address'))
            ->setMultiOptions($this->_getAddressMultiOptions());
        
        $delivery = new Form_Element_Radio(FieldIdEnum::DELIVERY_FORM_DELIVERY_ID);
        $delivery->setRequired()
            ->setLabel($this->_getTranslator()->translate('label-delivery_form_delivery'))
            ->setMultiOptions($this->_getDeliveryMultiOptions());
        
        $comment = new Form_Element_Textarea(FieldIdEnum::DELIVERY_FORM_COMMENT);
        $comment->setLabel($this->_getTranslator()->translate('label-delivery_form_comment'));
        
        $saveButton = new Zend_Form_Element_Submit(ParamIdEnum::FORM_SAVE_BUTTON);
        $saveButton->setIgnore(true);
        
        $this->addElements(array($id, $address, $delivery, $comment, $saveButton));
        
        $this->setDecorators(array(
            'FormElements',
            array('HtmlTag', array('tag' => 'dl', 'class' => 'zend_form')),
            array('Description', array('placement' => 'prepend')),
            'Form'
        ));
    }
    
    private function _getAddressMultiOptions()
    {
        $options = array();
        foreach ($this->_deliveryForm->Transaction->User->Addresses as $address)
            $options[$address->id] = $address->getOneLineInfo();
        
        return $options;
    }
    
    private function _getDeliveryMultiOptions()
    {
        $options = array();
        
        foreach ($this->_deliveryForm->Transaction->AuctionTransactionType->Auction->getDeliveryOptions(false) as $deliveryOption)
            $options[$deliveryOption->id] = Formatter_Price::formatWithCurrency($deliveryOption->price, $this->_deliveryForm->Transaction->AuctionTransactionType->Auction->Currency->name) . " " . $deliveryOption->DeliveryType->name . " " . $this->_getTranslator()->translate('message-delivery_options_cash_on_transaction');
        
        foreach ($this->_deliveryForm->Transaction->AuctionTransactionType->Auction->getDeliveryOptions(true) as $deliveryOption)
            $options[$deliveryOption->id] = Formatter_Price::formatWithCurrency($deliveryOption->price, $this->_deliveryForm->Transaction->AuctionTransactionType->Auction->Currency->name) . " " . $deliveryOption->DeliveryType->name . " " . $this->_getTranslator()->translate('message-delivery_options_cash_on_delivery');
        
        return $options;
    }
    
}
