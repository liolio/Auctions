<?php
/**
 * @class Validate_Transaction_Price
 */
class Validate_Transaction_Price extends Zend_Validate_Abstract
{
    const PRICE_TOO_LOW = 'priceTooLow';

    protected $_messageTemplates = array(
        self::PRICE_TOO_LOW      =>  'validation_message-transaction_price_lower_than_minimum_price',
    );
    
    public function isValid($value, $context = null)
    {
        $auctionTransactionType = AuctionTransactionTypeTable::getInstance()->getAuctionTransactionType(
                AuctionTable::getInstance()->find($context[FieldIdEnum::AUCTION_ID]), $context[FieldIdEnum::TRANSACTION_TYPE_NAME]);

        if ($auctionTransactionType->countPrice() > $value)
        {
            $this->_error(self::PRICE_TOO_LOW);
            return false;
        }
        
        return true;
    }
}
