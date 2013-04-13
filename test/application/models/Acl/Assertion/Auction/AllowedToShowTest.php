<?php
/**
 * @class Acl_Assertion_Auction_AllowedToShowTest
 */
class Acl_Assertion_Auction_AllowedToShowTest extends TestCase_Controller
{
    
    /**
     * @var Zend_Acl
     */
    private $_acl;

    protected function setUp()
    {
        $this->_disableLoggingInAdminUser();
        parent::setUp();
        $this->_acl = new Zend_Acl();
    }

    /**
     * @test
     */
    public function assertWithoutAuction()
    {
        $assertion = new Acl_Assertion_Auction_AllowedToShow(array(FieldIdEnum::AUCTION_ID => 1));
        $this->assertFalse($assertion->assert($this->_acl));
    }
    
    /**
     * @test
     * @dataProvider dataProvider
     */
    public function assertWithValidData($daysDiffFromNow, $logInOwner, $logInOtherUser, $logInAdministrator ,$result)
    {
        $this->_loadFixtures(array(
            "User/2",
            "User/5",
            "Category/1",
            "Currency/1",
            "Auction/3_category_1_start_2012-05-02_owner_2"
        ));
        
        
        Auth_User::getInstance()->clearUser();
        $this->assertFalse(Zend_Auth::getInstance()->hasIdentity());
        
        if ($logInOtherUser)
            $this->_logInUser('user5', 'admin');
        elseif ($logInOwner)
            $this->_logInUser('user', 'admin');
        elseif ($logInAdministrator)
            $this->_logInAdminUser();
        else
            $this->assertFalse(Zend_Auth::getInstance()->hasIdentity());
        
        $auction = AuctionTable::getInstance()->find(3);
        $auction->start_time = Zend_Date::now()->addDay($daysDiffFromNow)->toString(Time_Format::getFullDateTimeFormat());
        $auction->save();
        
        $assertion = new Acl_Assertion_Auction_AllowedToShow(array(FieldIdEnum::AUCTION_ID => $auction->id));
        $this->assertEquals($result, $assertion->assert($this->_acl));
    }
    
    public static function dataProvider()
    {
        return array(
                // no logged user
            array(-1, false, false, false, true),   // started one day ago, finish in next 6 days
            array(-10, false, false, false, false), // started ten days ago, finished 3 days ago
            array(10, false, false, false, false),  // start in next 10 days, finish in next 17 days
                // other user logged
            array(-1, false, true, false, true),   // started one day ago, finish in next 6 days
            array(-10, false, true, false, false), // started ten days ago, finished 3 days ago
            array(10, false, true, false, false),  // start in next 10 days, finish in next 17 days
                // owner logged
            array(-1, true, false, false, true),   // started one day ago, finish in next 6 days
            array(-10, true, false, false, true), // started ten days ago, finished 3 days ago
            array(10, true, false, false, true),  // start in next 10 days, finish in next 17 days
                // administrator logged
            array(-1, false, false, true, true),   // started one day ago, finish in next 6 days
            array(-10, false, false, true, true), // started ten days ago, finished 3 days ago
            array(10, false, false, true, true),  // start in next 10 days, finish in next 17 days
        );
    }   
    
}
