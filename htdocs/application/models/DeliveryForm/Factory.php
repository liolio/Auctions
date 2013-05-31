<?php
/**
 * @class DeliveryForm_Factory
 */
class DeliveryForm_Factory
{
    
    public static function create(Transaction $transaction)
    {
        $deliveryForm = new DeliveryForm();
        
        $deliveryForm->Transaction = $transaction;
        $deliveryForm->stage = Enum_Db_DeliveryForm_Stage::TO_FILL;
        
        return $deliveryForm;
    }
}
