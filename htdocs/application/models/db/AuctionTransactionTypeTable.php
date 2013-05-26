<?php

/**
 * AuctionTransactionTypeTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class AuctionTransactionTypeTable extends Doctrine_Table
{
    /**
     * Returns an instance of this class.
     *
     * @return object AuctionTransactionTypeTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('AuctionTransactionType');
    }
    
    public function getAuctionTransactionType(Auction $auction, $transactionTypeName)
    {
        return $this->createQuery()
                ->from('AuctionTransactionType att')
                ->addFrom('att.TransactionType tt')
                ->where('att.auction_id = ?', $auction->id)
                ->addWhere('tt.name = ?', $transactionTypeName)
                ->fetchOne();
    }
}