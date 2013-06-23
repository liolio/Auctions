<?php
/**
 * @class Auctions_DeliveryFormController_ProcessProcessFormActionTest
 */
class Auctions_DeliveryFormController_ProcessProcessFormActionTest extends TestCase_Controller
{
    
    /**
     * @test
     */
    public function process()
    {
        $this->_loadFixtures(array(
            'Currency/1',
            'Category/1',
            'Auction/1_category_1_start_2012-05-02',
            'AuctionTransactionType/2_auction_1_tt_1',
            'Transaction/1_att_2_u_1',
            'DeliveryType/1',
            'Delivery/1_delivery_type_1_auction_1',
            'DeliveryForm/3_transaction_1_to_process',
        ));
        
        $request = array(
            FieldIdEnum::DELIVERY_FORM_ID           =>  '3',
            ParamIdEnum::DELIVERY_FORM_IS_PROCESSED =>  '1',
        );
        
        $this->_setRequest($request);
        
        $this->dispatch("delivery-form/process-process-form");
        $this->_assertDispatch('delivery-form', 'process-process-form');
        
        $this->_assertRedirection('delivery-form/show-list');
        
        $deliveryForm = DeliveryFormTable::getInstance()->find(3);
        $this->assertEquals(Enum_Db_DeliveryForm_Stage::PROCESSED, $deliveryForm->stage);
    }
}
