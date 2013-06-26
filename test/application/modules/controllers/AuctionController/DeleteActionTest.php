<?php
/**
 * @class Auctions_AuctionController_DeleteActionTest
 */
class Auctions_AuctionController_DeleteActionTest extends TestCase_Controller
{
    
    /**
     * @test
     */
    public function delete()
    {
        $this->_loadFixtures(array(
            "Currency/1",
            "Category/1",
            "Auction/1_category_1_start_2012-05-02"
        ));
        
        $this->dispatch('/auction/delete/1');
        $this->_assertDispatch('auction', 'delete');
        
        $this->_assertRedirection("auction/show-list-for-category/1");
        
        $this->assertEquals(0, AuctionTable::getInstance()->count());
        
        $this->assertEquals(ParamIdEnum::WINDOW_AUCTION_DELETED, Session_DialogWindow::getValue());
    }
    
}
