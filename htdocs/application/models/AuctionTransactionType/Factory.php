<?php
/**
 * @class AuctionTransactionType_Factory
 */
class AuctionTransactionType_Factory
{
    
    public static function create(array $data, Auction $auction)
    {
        $auctionTransactionType = new AuctionTransactionType();
        
        $auctionTransactionType->price = $data[FieldIdEnum::AUCTION_TRANSACTION_TYPE_PRICE];
        $auctionTransactionType->TransactionType = TransactionTypeTable::getInstance()->findOneBy('name', $data[FieldIdEnum::TRANSACTION_TYPE_NAME]);
        $auctionTransactionType->Auction = $auction;
        
        return $auctionTransactionType;
    }
}
