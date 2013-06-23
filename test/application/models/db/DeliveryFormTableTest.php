<?php
/**
 * @class DeliveryFormTableTest
 */
class DeliveryFormTableTest extends TestCase_Database
{
    
    /**
     * @test
     */
    public function getFormsForUserAndStage()
    {
        $this->_loadFixtures(array(
            'Currency/1',
            'Category/1',
            'Auction/1_category_1_start_2012-05-02',
            'AuctionTransactionType/2_auction_1_tt_1',
            'Transaction/1_att_2_u_1',
            'DeliveryForm/1_transaction_1_to_fill',
            'DeliveryForm/2_transaction_1_to_fill',
            'DeliveryForm/3_transaction_1_to_process',
        ));
        
        $forms = DeliveryFormTable::getInstance()->getFormsForUserAndStage(UserTable::getInstance()->find(1), Enum_Db_DeliveryForm_Stage::TO_FILL);
        $this->assertEquals(2, count($forms));
        
        $this->assertEquals(Enum_Db_DeliveryForm_Stage::TO_FILL, $forms->get(0)->stage);
        $this->assertEquals(Enum_Db_DeliveryForm_Stage::TO_FILL, $forms->get(1)->stage);
    }
}
