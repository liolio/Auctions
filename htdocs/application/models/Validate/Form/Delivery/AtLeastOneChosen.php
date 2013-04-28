<?php
/**
 * @class Validate_Form_Delivery_AtLeastOneChosen
 */
class Validate_Form_Delivery_AtLeastOneChosen extends Validate_Form
{

    public function isValid(Zend_Form $form)
    {
        foreach (DeliveryTypeTable::getInstance()->getIds() as $deliveryTypeId)
        {
            if ($form->getElement(FieldIdEnum::DELIVERY_TYPE_ID . "_" . $deliveryTypeId)->getValue() != 0)
                return true;
        }
        
        $this->_setMessage($this->_getTranslator()->translate('validation_message-delivery_at_least_one_not_chosen'));
        return false;
    }
    
}
