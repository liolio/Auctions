<?php
/**
 * @class Auctions_AuctionController_ProcessEditFormActionTest
 */
class Auctions_AuctionController_ProcessEditFormActionTest extends TestCase_Controller
{
    
    /**
     * @test
     */
    public function process()
    {
        $this->_loadFixtures(array(
            "Currency/1",
            "Category/1",
            "Auction/1_category_1_start_2012-05-02"
        ));
        
        $request = array(
            FieldIdEnum::AUCTION_ID     =>  '1',
            FieldIdEnum::AUCTION_TITLE  =>  'new title',
            ParamIdEnum::CKEDITOR       =>  'new description',
        );
        
        $this->_setRequest($request);
        
        $this->dispatch("auction/process-edit-form");
        $this->_assertDispatch('auction', 'process-edit-form');
        
        $this->_assertRedirection("auction/show/1");
        
        $auctions = AuctionTable::getInstance()->findAll();
        $this->assertEquals(1, count($auctions));
        
        $auction = $auctions->get(0);
        $this->assertEquals($request[FieldIdEnum::AUCTION_ID], $auction->id);
        $this->assertEquals($request[FieldIdEnum::AUCTION_TITLE], $auction->title);
        $this->assertEquals($request[ParamIdEnum::CKEDITOR], $auction->description);
    }
    
    /**
     * @test
     */
    public function processWithInvalidData()
    {
        $this->_loadFixtures(array(
            "Currency/1",
            "Category/1",
            "Auction/1_category_1_start_2012-05-02"
        ));
        
        $this->_setRequest(array(
            FieldIdEnum::AUCTION_ID => '1'
        ));
        
        $this->dispatch("auction/process-edit-form");
        $this->_assertDispatch('auction', 'process-edit-form');
        $this->assertContains(Helper::getTranslator()->translate("validation_message-field_empty"), $this->getResponse()->getBody());
        
        $this->assertEquals(1, AuctionTable::getInstance()->count());
    }
}
