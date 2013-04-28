<?php
/**
 * @class Validate_Form_AuctionTransactionType_AtLeastOneChosen
 */
class Validate_Form_AuctionTransactionType_AtLeastOneChosen extends Validate_Form
{

    public function isValid(Zend_Form $form)
    {
        if ($form->getElement(ParamIdEnum::AUCTION_TRANSACTION_TYPE_BIDDING)->getValue() != 0)
            return true;
        
        if ($form->getElement(ParamIdEnum::AUCTION_TRANSACTION_TYPE_BUY_OUT)->getValue() != 0)
            return true;
        
        $this->_setMessage($this->_getTranslator()->translate('validation_message-auction_transaction_type_at_least_one_not_chosen'));
        return false;
    }
    
}
