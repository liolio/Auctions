<?php
/**
 * @class Cron_Job_FinishAuctionsTest
 */
class Cron_Job_FinishAuctionsTest extends TestCase_Mail
{
    
    /**
     * @test
     */
    public function runTest()
    {
        $this->_loadFixtures(array(
            'Category/1',
            'Currency/1',
            'Auction/5_category_1_start_2012-05-02',
            'AuctionTransactionType/4_auction_5_tt_1',
            'AuctionTransactionType/5_auction_5_tt_2',
            'User/2',
            'User/3_inactive',
            'Address/3_user_2',
            'Address/4_user_3',
            "Transaction/3_att_4_u_1", 
            "Transaction/5_att_5_u_1", 
            "Transaction/7_att_4_u_3"
        ));
        
        $job = new FinishAuctionsMock();
        $job->run();
        
        $auction = AuctionTable::getInstance()->find(5);
        $this->assertEquals(Enum_Db_Auction_Stage::FINISHED, $auction->stage);
        
        $notifications = NotificationTable::getInstance()->findAll();
        $this->assertEquals(2, count($notifications));
        
        $notification1 = $notifications->get(0);
        $this->assertEquals(7, $notification1->related_object_id);
        $this->assertEquals(Enum_Db_Notification_Type::AUCTION_BID_WINNER, $notification1->type);
        
        $notification2 = $notifications->get(1);
        $this->assertEquals(5, $notification2->related_object_id);
        $this->assertEquals(Enum_Db_Notification_Type::AUCTION_FINISHED_OWNER, $notification2->type);
        
        $logs = LogTable::getInstance()->findAll();
        $this->assertEquals(1, count($logs));
        $this->assertEquals('Finished 1 auctions.', $logs->get(0)->message);
    }
}

class FinishAuctionsMock extends Cron_Job_FinishAuctions
{
    
    protected function _getNow()
    {
        return new Zend_Date("2013-05-02 22:22:22");
    }
}
