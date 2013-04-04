<?php

/**
 * AuctionTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class AuctionTable extends Doctrine_Table
{
    /**
     * Returns an instance of this class.
     *
     * @return object AuctionTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('Auction');
    }
    
    /**
     * Returns array in format:
     *  {auction_id} => array(
     *      auction_title,
     *      auction_end_time,
     *      auction_prices[]
     *  )
     * 
     * @param Category $category
     * @param Zend_Date $now
     * @return type
     */
    public function getAuctionsAllChildrenAuctions(Category $category, Zend_Date $now)
    {
        $categoryIds = $category->getCategoryAllChildrenIds();
        $categoryIds[] = $category->id;
        
        $auctionTransactionTypes = $this->createQuery()
                ->select('a.id as ' . FieldIdEnum::AUCTION_ID)
                ->addSelect('a.title as ' . FieldIdEnum::AUCTION_TITLE)
                ->addSelect('ADDDATE(a.start_time, a.duration) as ' . ParamIdEnum::AUCTION_END_TIME)
                ->addSelect('att.price as ' . FieldIdEnum::AUCTION_TRANSACTION_TYPE_PRICE)
                ->addSelect('tt.name as ' . FieldIdEnum::TRANSACTION_TYPE_NAME)
                ->from('AuctionTransactionType att')
                ->leftJoin('att.TransactionType tt')
                ->leftJoin('att.Auction a')
                ->whereIn('category_id', $categoryIds)
                ->addWhere('start_time <= ?', $now->toString(Time_Format::getFullDateTimeFormat()))
                ->addWhere('ADDDATE(a.start_time, a.duration) >= ?', $now->toString(Time_Format::getFullDateTimeFormat()))
                ->fetchArray();
        
        return $this->_getAuctionsToListFromAuctionTransactionTypes($auctionTransactionTypes);
    }
    
    /**
     * Converts array with Auction Transaction Types data into array with Auctions date.
     * If 2 Auction Transaction Types are definned, bidding is the first one.
     * Used to show auctions list function.
     * 
     * @param array $auctionTransactionTypes
     * @return array
     */
    private function _getAuctionsToListFromAuctionTransactionTypes(array $auctionTransactionTypes)
    {
        $auctions = array();
        
        foreach ($auctionTransactionTypes as $auctionTransactionType)
        {
            if (array_key_exists($auctionTransactionType[FieldIdEnum::AUCTION_ID], $auctions))
            {
                //Bidding must have index zero
                if ($auctions[$auctionTransactionType[FieldIdEnum::AUCTION_ID]][ParamIdEnum::AUCTION_PRICES][0][FieldIdEnum::TRANSACTION_TYPE_NAME] === Enum_Db_TransactionType_Type::BUY_OUT)
                {
                    $auctions[$auctionTransactionType[FieldIdEnum::AUCTION_ID]][ParamIdEnum::AUCTION_PRICES][1] = $auctions[$auctionTransactionType[FieldIdEnum::AUCTION_ID]][ParamIdEnum::AUCTION_PRICES][0];
                    $index = 0;
                }
                else
                    $index = 1;
                
                $auctions[$auctionTransactionType[FieldIdEnum::AUCTION_ID]][ParamIdEnum::AUCTION_PRICES][$index] = array(
                    FieldIdEnum::TRANSACTION_TYPE_NAME          =>  $auctionTransactionType[FieldIdEnum::TRANSACTION_TYPE_NAME],
                    FieldIdEnum::AUCTION_TRANSACTION_TYPE_PRICE =>  $auctionTransactionType[FieldIdEnum::AUCTION_TRANSACTION_TYPE_PRICE]
                );
            }
            else
                $auctions[$auctionTransactionType[FieldIdEnum::AUCTION_ID]] = $this->_getAuctionToListFromAuctionTransactionType($auctionTransactionType);
        }
        
        return $auctions;
    }
    
    /**
     * Converts array with Auction Transaction Type data into array with Auction date.
     * Used to show auctions list function.
     * 
     * @param array $auctionTransactionType
     * @return array
     */
    private function _getAuctionToListFromAuctionTransactionType(array $auctionTransactionType)
    {
        return array(
            FieldIdEnum::AUCTION_TITLE      =>  $auctionTransactionType[FieldIdEnum::AUCTION_TITLE],
            ParamIdEnum::AUCTION_END_TIME   =>  $auctionTransactionType[ParamIdEnum::AUCTION_END_TIME],
            ParamIdEnum::AUCTION_PRICES     =>  array(
                array(
                    FieldIdEnum::TRANSACTION_TYPE_NAME          =>  $auctionTransactionType[FieldIdEnum::TRANSACTION_TYPE_NAME],
                    FieldIdEnum::AUCTION_TRANSACTION_TYPE_PRICE =>  $auctionTransactionType[FieldIdEnum::AUCTION_TRANSACTION_TYPE_PRICE]
                )
            )
        );
    }
    
}