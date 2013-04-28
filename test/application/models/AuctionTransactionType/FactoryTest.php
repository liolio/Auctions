<?php
/**
 * @class AuctionTransactionType_FactoryTest
 */
class AuctionTransactionType_FactoryTest extends TestCase_Database
{
    /**
     * @test
     */
    public function create()
    {
        $this->_loadFixtures(array(
            'Category/1',
            'Currency/1',
            'Auction/1_category_1_start_2012-05-02',
        ));
        
        $auction = AuctionTable::getInstance()->find(1);
        
        $data = array(
            FieldIdEnum::AUCTION_TRANSACTION_TYPE_PRICE =>  '2.00',
            FieldIdEnum::TRANSACTION_TYPE_NAME          =>  Enum_Db_TransactionType_Type::BIDDING
        );
        
        $auctionTransactionType = AuctionTransactionType_Factory::create($data, $auction);
        
        $this->assertEquals($data[FieldIdEnum::AUCTION_TRANSACTION_TYPE_PRICE], $auctionTransactionType->price);
        $this->assertEquals($data[FieldIdEnum::TRANSACTION_TYPE_NAME], $auctionTransactionType->TransactionType->name);
        $this->assertEquals(1, $auctionTransactionType->auction_id);
    }
}
