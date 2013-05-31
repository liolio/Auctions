<?php
/**
 * @class Cron_Job_FinishAuctions
 */
class Cron_Job_FinishAuctions extends Cron_Job
{
    
    /**
     * @var Notification_Sender
     */
    private $_sender;
    
    protected function _execute()
    {
        $counter = 0;
        
        foreach(AuctionTable::getInstance()->getAuctionsToFinish($this->_getNow()) as $auction)
        {
            $bidding = AuctionTransactionTypeTable::getInstance()->getAuctionTransactionType($auction, Enum_Db_TransactionType_Type::BIDDING);
            if ($bidding !== false)
            {
                $transactions = $bidding->getItemsToShow();
                foreach($transactions[ParamIdEnum::TRANSACTION_VALID] as $transaction)
                {
                    DeliveryForm_Factory::create($transaction);
                    $this->_getSender()->send($transaction, Enum_Db_Notification_Type::AUCTION_BID_WINNER);
                }
            }
            
            $this->_getSender()->send($auction, Enum_Db_Notification_Type::AUCTION_FINISHED_OWNER);
            $auction->stage = Enum_Db_Auction_Stage::FINISHED;
            $auction->save();
            $counter++;
        }
        
        if ($counter > 0)
            Log_Factory::createInfo('Finished ' . $counter . ' auctions.');
    }
    
    private function _getSender()
    {
        if (is_null($this->_sender))
            $this->_sender = new Notification_Sender();
        
        return $this->_sender;
    }
}
