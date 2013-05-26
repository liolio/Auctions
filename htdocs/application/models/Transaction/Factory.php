<?php
/**
 * @class Transaction_Factory
 */
class Transaction_Factory
{
    
    /**
     * Creates new Notification object.
     * 
     * @param String $relatedObjectId
     * @param Enum_Db_Notification_Type $notificationType
     * @return Notification
     */
    public static function create(User $user, AuctionTransactionType $auctionTransactionType, $data)
    {
        $transaction = new Transaction();
        
        $transaction->User = $user;
        $transaction->AuctionTransactionType = $auctionTransactionType;
        $transaction->price = $data[FieldIdEnum::TRANSACTION_PRICE];
        $transaction->number_of_items = $data[FieldIdEnum::TRANSACTION_NUMBER_OF_ITEMS];
        
        return $transaction;
    }
}
