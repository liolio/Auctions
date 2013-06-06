<?php
/**
 * @class DeliveryForm_FactoryTest
 */
class DeliveryForm_FactoryTest extends TestCase_Database
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
            'AuctionTransactionType/2_auction_1_tt_1',
            'Transaction/1_att_2_u_1',
        ));
        
        $deliveryForm = DeliveryForm_Factory::create(TransactionTable::getInstance()->find(1));
        
        $this->assertEquals(1, $deliveryForm->transaction_id);
        $this->assertEquals(Enum_Db_DeliveryForm_Stage::TO_FILL, $deliveryForm->stage);
    }
}
