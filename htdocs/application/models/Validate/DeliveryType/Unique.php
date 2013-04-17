<?php
/**
 * @class Validate_DeliveryType_Unique
 */
class Validate_DeliveryType_Unique extends Zend_Validate_Abstract
{
    const NOT_UNIQUE = 'notUnique';

    protected $_messageTemplates = array(
        self::NOT_UNIQUE    =>  'validation_message-delivery_type_not_unique',
    );
    
    public function isValid($value, $context = null)
    {
        $deliveryTypeId = array_key_exists(FieldIdEnum::DELIVERY_TYPE_ID, $context) ? $context[FieldIdEnum::DELIVERY_TYPE_ID] : null;
        
        if (!DeliveryTypeTable::getInstance()->isUnique(
            $value,
            $context[FieldIdEnum::DELIVERY_TYPE_CASH_ON_DELIVERY],
            $deliveryTypeId
        ))
        {
            $this->_error(self::NOT_UNIQUE);
            return false;
        }
        
        return true;
    }
}
