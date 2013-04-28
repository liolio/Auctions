<?php
/**
 * @class Form_Elements_Delivery
 */
class Form_Elements_Delivery extends Form_Elements
{
    
    /**
     * Returns array of Zend Form Elements related to delivery with cash on delivery.
     *  
     * @return Zend_Form_Element[]
     */
    public function getCashOnDeliveryElements()
    {
        return $this->_getDeliveryFieldsFromCollection(DeliveryTypeTable::getInstance()->findBy('cash_on_delivery', true));
    }
    
    /**
     * Returns array of Zend Form Elements related to delivery with cash not on delivery.
     * 
     * @return Zend_Form_Element[]
     */
    public function getCashByTransferElements()
    {
        return $this->_getDeliveryFieldsFromCollection(DeliveryTypeTable::getInstance()->findBy('cash_on_delivery', false));
    }
    
    /**
     * Creates array of Zend Form Element related to Delivery based on parameter.
     * 
     * @param Doctrine_Collection $collection Basing on this array, this method creates proper array.
     * @return Zend_Form_Element[]
     */
    private function _getDeliveryFieldsFromCollection(Doctrine_Collection $collection)
    {
        $fields = array();
        
        foreach ($collection as $deliveryType)
        {
            $deliveryTypeCheckbox = new Zend_Form_Element_Checkbox(FieldIdEnum::DELIVERY_TYPE_ID . "_" . $deliveryType->id);
            $deliveryTypeCheckbox->setLabel($this->_getTranslator()->translate($deliveryType->name));
            
            $deliveryPrice = new Form_Element_Text(FieldIdEnum::DELIVERY_PRICE . "_" . $deliveryType->id);
            $deliveryPrice->setRequired()
                    ->setLabel($this->_getTranslator()->translate('label-auction_transaction_price'))
                    ->addValidator(new Validate_StringLength(array('min' => 1, 'max' => 15)), true)
                    ->addValidator(new Validate_Float());
            
            $fields[] = $deliveryTypeCheckbox;
            $fields[] = $deliveryPrice;
        }
        
        return $fields;
    }
    
}
