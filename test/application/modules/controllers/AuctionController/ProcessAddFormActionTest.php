<?php
/**
 * @class Auctions_AuctionController_ProcessAddFormActionTest
 */
class Auctions_AuctionController_ProcessAddFormActionTest extends TestCase_Controller
{
    
    /**
     * @test
     */
    public function process()
    {
        Auctions_Form_Auction_Add::addFileFields(false);
        $this->_loadFixtures(array(
            "DeliveryType/1",
            "DeliveryType/2",
            "DeliveryType/3",
            "DeliveryType/4",
            "Category/1",
            "Category/3_parent_1",
            "Currency/1",
        ));
        
        $request = array(
            FieldIdEnum::CATEGORY_ID                            =>  '3',
            FieldIdEnum::AUCTION_TITLE                          =>  'auction title',
            ParamIdEnum::CKEDITOR                               =>  '<b>auction <u>description</u></b>',
            FieldIdEnum::AUCTION_START_TIME                     =>  '2012-05-02 22:22:12',
            FieldIdEnum::AUCTION_DURATION                       =>  Enum_Db_Auction_Duration::DURATION_21,
            FieldIdEnum::AUCTION_NUMBER_OF_ITEMS                =>  '10',
            FieldIdEnum::CURRENCY_ID                            =>  '1',
            ParamIdEnum::AUCTION_TRANSACTION_TYPE_BIDDING       =>  '1',
            ParamIdEnum::AUCTION_TRANSACTION_TYPE_BIDDING_PRICE =>  '99.69',
            ParamIdEnum::AUCTION_TRANSACTION_TYPE_BUY_OUT       =>  '1',
            ParamIdEnum::AUCTION_TRANSACTION_TYPE_BUY_OUT_PRICE =>  '123.32',
            FieldIdEnum::DELIVERY_TYPE_ID . "_3"                =>  '1',
            FieldIdEnum::DELIVERY_PRICE . "_3"                  =>  '30.00',
            FieldIdEnum::DELIVERY_TYPE_ID . "_2"                =>  '1',
            FieldIdEnum::DELIVERY_PRICE . "_2"                  =>  '20.00',
            FieldIdEnum::DELIVERY_TYPE_ID . "_1"                =>  '1',
            FieldIdEnum::DELIVERY_PRICE . "_1"                  =>  '10.00',
            FieldIdEnum::DELIVERY_TYPE_ID . "_4"                =>  '',
            FieldIdEnum::DELIVERY_PRICE . "_4"                  =>  ''
        );
        
        $this->_setRequest($request);
        
        $this->dispatch("auction/process-add-form");
        $this->_assertDispatch('auction', 'process-add-form');
        
        $this->_assertRedirection('auction/show/1');
        
        $auction = AuctionTable::getInstance()->find(1);
        
        $this->assertEquals($request[FieldIdEnum::CATEGORY_ID], $auction->category_id);
        $this->assertEquals($request[FieldIdEnum::AUCTION_TITLE], $auction->title);
        $this->assertEquals($request[ParamIdEnum::CKEDITOR], $auction->description);
        $this->assertEquals($request[FieldIdEnum::AUCTION_START_TIME], $auction->start_time);
        $this->assertEquals($request[FieldIdEnum::AUCTION_DURATION], $auction->duration);
        $this->assertEquals($request[FieldIdEnum::AUCTION_NUMBER_OF_ITEMS], $auction->number_of_items);
        $this->assertEquals($request[FieldIdEnum::CURRENCY_ID], $auction->currency_id);
        
        $auctionTransactionTypes = $auction->AuctionTransactionTypes;
        $this->assertEquals(2, count($auctionTransactionTypes));
        
        $this->assertEquals(
                $request[ParamIdEnum::AUCTION_TRANSACTION_TYPE_BIDDING_PRICE], 
                $this->_getAuctionTransactionTypePrice(1)
        );
        $this->assertEquals(
                $request[ParamIdEnum::AUCTION_TRANSACTION_TYPE_BUY_OUT_PRICE], 
                $this->_getAuctionTransactionTypePrice(2)
        );
        
        $deliveries = $auction->Deliveries;
        $this->assertEquals(3, count($deliveries));
        $this->assertEquals($request[FieldIdEnum::DELIVERY_PRICE . "_1"], $this->_getDeliveryPrice(1));
        $this->assertEquals($request[FieldIdEnum::DELIVERY_PRICE . "_2"], $this->_getDeliveryPrice(2));
        $this->assertEquals($request[FieldIdEnum::DELIVERY_PRICE . "_3"], $this->_getDeliveryPrice(3));
        
        Auctions_Form_Auction_Add::addFileFields(true);
    }
    
    /**
     * @test
     */
    public function processWithInvalidData()
    {
         $this->_loadFixtures(array(
            "DeliveryType/1",
            "DeliveryType/2",
            "DeliveryType/3",
            "DeliveryType/4",
            "Category/1",
            "Category/3_parent_1",
            "Currency/1",
        ));
        
        $this->_setRequest(array(
            FieldIdEnum::CATEGORY_ID                            =>  '',
            FieldIdEnum::AUCTION_TITLE                          =>  '',
            ParamIdEnum::CKEDITOR                               =>  '',
            FieldIdEnum::AUCTION_START_TIME                     =>  '',
            FieldIdEnum::AUCTION_DURATION                       =>  '',
            FieldIdEnum::AUCTION_NUMBER_OF_ITEMS                =>  '',
            FieldIdEnum::CURRENCY_ID                            =>  '',
            ParamIdEnum::AUCTION_TRANSACTION_TYPE_BIDDING       =>  '1',
            ParamIdEnum::AUCTION_TRANSACTION_TYPE_BIDDING_PRICE =>  '',
            ParamIdEnum::AUCTION_TRANSACTION_TYPE_BUY_OUT       =>  '1',
            ParamIdEnum::AUCTION_TRANSACTION_TYPE_BUY_OUT_PRICE =>  '',
            FieldIdEnum::DELIVERY_TYPE_ID . "_3"                =>  '1',
            FieldIdEnum::DELIVERY_PRICE . "_3"                  =>  '',
            FieldIdEnum::DELIVERY_TYPE_ID . "_2"                =>  '1',
            FieldIdEnum::DELIVERY_PRICE . "_2"                  =>  '',
            FieldIdEnum::DELIVERY_TYPE_ID . "_1"                =>  '1',
            FieldIdEnum::DELIVERY_PRICE . "_1"                  =>  '',
            FieldIdEnum::DELIVERY_TYPE_ID . "_4"                =>  '1',
            FieldIdEnum::DELIVERY_PRICE . "_4"                  =>  ''
        ));
        
        $this->dispatch("auction/process-add-form");
        $this->_assertDispatch('auction', 'process-add-form');
        $this->assertContains(Helper::getTranslator()->translate("validation_message-field_empty"), $this->getResponse()->getBody());
        
        $this->assertEquals(0, AuctionTable::getInstance()->count());
    }
    
    private function _getAuctionTransactionTypePrice($transactionTypeId)
    {
        return AuctionTransactionTypeTable::getInstance()
            ->createQuery()
            ->select('price')
            ->where('auction_id = ?', 1)
            ->addWhere('transaction_type_id = ?', $transactionTypeId)
            ->execute(array(), Doctrine_Core::HYDRATE_SINGLE_SCALAR);
    }
    
    private function _getDeliveryPrice($deliveryTypeId)
    {
        return DeliveryTable::getInstance()
            ->createQuery()
            ->select('price')
            ->where('auction_id = ?', 1)
            ->addWhere('delivery_type_id = ?', $deliveryTypeId)
            ->execute(array(), Doctrine_Core::HYDRATE_SINGLE_SCALAR);
    }
}
