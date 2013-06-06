<?php
/**
 * @class Auctions_DeliveryFormController_ProcessAddFormActionTest
 */
class Auctions_DeliveryFormController_ProcessAddFormActionTest extends TestCase_Mail
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
            'DeliveryForm/1_transaction_1_to_fill',
        ));
        
        $request = array(
            FieldIdEnum::DELIVERY_FORM_ID           =>  '1',
            FieldIdEnum::DELIVERY_FORM_ADDRESS_ID   =>  '1',
            FieldIdEnum::DELIVERY_FORM_DELIVERY_ID  =>  '1',
            FieldIdEnum::DELIVERY_FORM_COMMENT      =>  'comment asd',
        );
        
        $this->_setRequest($request);
        
        $this->dispatch("delivery-form/process-add-form");
        $this->_assertDispatch('delivery-form', 'process-add-form');
        
        $this->_assertRedirection('');
        
        $deliveryForm = DeliveryFormTable::getInstance()->find(1);
        $this->assertEquals($request[FieldIdEnum::DELIVERY_FORM_ADDRESS_ID], $deliveryForm->address_id);
        $this->assertEquals($request[FieldIdEnum::DELIVERY_FORM_DELIVERY_ID], $deliveryForm->delivery_id);
        $this->assertEquals($request[FieldIdEnum::DELIVERY_FORM_COMMENT], $deliveryForm->comment);
    }
    
    /**
     * @test
     */
    public function processWithMissingData()
    {
        $this->_loadFixtures(array(
            'Currency/1',
            'Category/1',
            'Auction/1_category_1_start_2012-05-02',
            'AuctionTransactionType/2_auction_1_tt_1',
            'Transaction/1_att_2_u_1',
            'DeliveryType/1',
            'Delivery/1_delivery_type_1_auction_1',
            'DeliveryForm/1_transaction_1_to_fill',
        ));
        
        $this->_setRequest(array(FieldIdEnum::DELIVERY_FORM_ID => '1'));
        
        $this->dispatch("delivery-form/process-add-form");
        $this->_assertDispatch('delivery-form', 'process-add-form');
        
        $this->assertContains($this->_getTranslator()->translate('validation_message-field_empty'), $this->getResponse()->getBody());
    }
    
    /**
     * @test
     */
    public function processAlreadyFilled()
    {
        $this->_loadFixtures(array(
            'Currency/1',
            'Category/1',
            'Auction/1_category_1_start_2012-05-02',
            'AuctionTransactionType/2_auction_1_tt_1',
            'Transaction/1_att_2_u_1',
            'DeliveryType/1',
            'Delivery/1_delivery_type_1_auction_1',
            'DeliveryForm/1_t_1_add_1_d_1_to_process',
        ));
        
        $request = array(
            FieldIdEnum::DELIVERY_FORM_ID           =>  '1',
            FieldIdEnum::DELIVERY_FORM_ADDRESS_ID   =>  '1',
            FieldIdEnum::DELIVERY_FORM_DELIVERY_ID  =>  '1',
            FieldIdEnum::DELIVERY_FORM_COMMENT      =>  'comment asd',
        );
        
        $this->_setRequest($request);
        
        $this->dispatch("delivery-form/process-add-form");
        $this->_assertDispatch('delivery-form', 'process-add-form');
        
        $this->assertContains(
            $this->_getTranslator()->translate('validation_message-delivery_form_already_filled'),
            $this->getResponse()->getBody()
        );
    }
}
