<?php
/**
 * @class Auction_ViewHelper
 */
class Auction_ViewHelper
{
    
    /**
     * 
     * @param AuctionTransactionType $auctionTransactionType
     * @return String HTML div with proper data
     * @throws InvalidArgumentException when Transaction Type is not supported
     */
    public static function getTransactionDiv(AuctionTransactionType $auctionTransactionType)
    {
        switch ($auctionTransactionType->TransactionType->name) {
            case Enum_Db_TransactionType_Type::BIDDING :
                $divId = 'bidding';
                $labelKey = 'label-auction_transaction_type_bidding_price';
                $buttonClassName = ParamIdEnum::AUCTION_TRANSACTION_TYPE_BIDDING;
                $linkPart = 'bid';
                break;
            case Enum_Db_TransactionType_Type::BUY_OUT :
                $divId = 'buyOut';
                $labelKey = 'label-auction_transaction_type_buy_out_price';
                $buttonClassName = ParamIdEnum::AUCTION_TRANSACTION_TYPE_BUY_OUT;
                $linkPart = 'buy-out';
                break;
            default :
                throw new InvalidArgumentException($this->TransactionType->name . ' is not supported yet');
        }
        
        return "<div id='" . $divId . "'> " .
            Helper::getTranslator()->translate($labelKey) . " <strong>" . Formatter_Price::formatWithCurrency($auctionTransactionType->countPrice(), $auctionTransactionType->Auction->Currency->name) . "</strong><br/>" .
            "<a class=" . $buttonClassName . " href='" . Zend_Controller_Front::getInstance()->getBaseUrl() . "/transaction/" . $linkPart . "/" . $auctionTransactionType->Auction->id . "'></a>" .
        "</div>";
    }
}
