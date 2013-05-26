<?php
/**
 * @class Validate_Transaction_NumberOfItems
 */
class Validate_Transaction_NumberOfItems extends Zend_Validate_Abstract
{
    const NUMBER_OF_ITEMS_TOO_HIGH = 'numberOfItemsTooHigh';

    protected $_messageTemplates = array(
        self::NUMBER_OF_ITEMS_TOO_HIGH      =>  'validation_message-transaction_number_of_items_greater_than_items_left',
    );
    
    public function isValid($value, $context = null)
    {
        $auction = AuctionTable::getInstance()->find($context[FieldIdEnum::AUCTION_ID]);
        
        if (TransactionTable::getInstance()->getNumberOfItemsLeftForAuctionAndTransactionTypeName($auction) < $value)
        {
            $this->_error(self::NUMBER_OF_ITEMS_TOO_HIGH);
            return false;
        }
        
        return true;
    }
}
