<?php
/**
 * @class Transaction_FactoryTest
 */
class Transaction_FactoryTest extends TestCase_Controller
{
    
    /**
     * @test
     */
    public function create()
    {
        $this->_loadFixtures(array(
            'Currency/1',
            'Category/1',
            'Auction/1_category_1_start_2012-05-02',
            'AuctionTransactionType/1_auction_1_tt_2'
        ));
        
        $data = array(
            FieldIdEnum::TRANSACTION_PRICE              =>  '1.00',
            FieldIdEnum::TRANSACTION_NUMBER_OF_ITEMS    =>  '1',
        );
        
        $transaction = Transaction_Factory::create(
            $this->_getLoggedUser(),
            AuctionTransactionTypeTable::getInstance()->find(1),
            $data
        );
        
        $this->assertEquals('admin', $transaction->User->login);
        $this->assertEquals('1', $transaction->AuctionTransactionType->id);
        $this->assertEquals($data[FieldIdEnum::TRANSACTION_PRICE], $transaction->price);
        $this->assertEquals($data[FieldIdEnum::TRANSACTION_NUMBER_OF_ITEMS], $transaction->number_of_items);
    }
}
