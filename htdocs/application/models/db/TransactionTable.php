<?php

/**
 * TransactionTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class TransactionTable extends Doctrine_Table
{
    /**
     * Returns an instance of this class.
     *
     * @return object TransactionTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('Transaction');
    }
    
    /**
     * Returns number of items left, available to buy out or bidding.
     * 
     * @param Auction $auction
     * @return Integer 
     */
    public function getNumberOfItemsLeftForAuctionAndTransactionTypeName(Auction $auction)
    {
        $result = $this->createQuery()
                ->select('(a.number_of_items - SUM(t.number_of_items)) as number_of_items_left')
                ->addSelect('t.id')
                ->addSelect('tt.id')
                ->addSelect('att.id')
                ->addSelect('a.id')
                ->from('Transaction t')
                ->leftJoin('t.AuctionTransactionType att')
                ->leftJoin('att.Auction a')
                ->leftJoin('att.TransactionType tt')
                ->where('att.auction_id = ?', $auction->id)
                ->addWhere('tt.name = ?', Enum_Db_TransactionType_Type::BUY_OUT)
                ->groupBy('a.id')
                ->execute();
        
        if (count($result) === 0)
            return $auction->number_of_items;
        
        return $result->getFirst()->number_of_items_left;
    }
    
    /**
     * 
     * @param Auction $auction
     * @return Doctrine_Collection
     */
    public function getBiddingsForAuction(Auction $auction)
    {
        return $this->createQuery()
                ->select('t.number_of_items')
                ->addSelect('t.price')
                ->from('Transaction t')
                ->leftJoin('t.AuctionTransactionType att')
                ->leftJoin('att.Auction a')
                ->leftJoin('att.TransactionType tt')
                ->where('att.auction_id = ?', $auction->id)
                ->addWhere('tt.name = ?', Enum_Db_TransactionType_Type::BIDDING)
                ->orderBy('t.price DESC')
                ->addOrderBy('t.number_of_items DESC')
                ->execute();
    }
    
}