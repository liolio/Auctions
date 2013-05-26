<?php
/**
 * @class TransactionTest
 */
class TransactionTest extends TestCase_Controller
{
    
    /**
     * @test
     * @dataProvider getNotificationDataDataProvider
     */
    public function getNotificationData($fixture, $transactionId, $notificationType, array $expectedData)
    {
        $this->_loadFixtures(array(
            'Category/1',
            'Currency/1',
            'Auction/5_category_1_start_2012-05-02',
            'AuctionTransactionType/4_auction_5_tt_1',
            'AuctionTransactionType/5_auction_5_tt_2',
            $fixture
        ));
        
        $this->assertEquals($expectedData, TransactionTable::getInstance()->find($transactionId)->getNotificationData($notificationType));
    }
    
    public function getNotificationDataDataProvider()
    {
        return array(
            array(
                'Transaction/5_att_5_u_1',
                5,
                Enum_Db_Notification_Type::AUCTION_BID_BIDDER,
                array(
                    FieldIdEnum::AUCTION_TITLE                  =>  'Auction 5',
                    ParamIdEnum::USER_FULLNAME                  =>  'Admin Adminowy',
                    ParamIdEnum::LINK                           =>  '/auction/show/5',
                    FieldIdEnum::TRANSACTION_NUMBER_OF_ITEMS    =>  '2',
                    FieldIdEnum::TRANSACTION_PRICE              =>  Formatter_Price::formatWithCurrency('122.12', 'PLN')
                )
            ),
            array(
                'Transaction/5_att_5_u_1',
                5,
                Enum_Db_Notification_Type::AUCTION_BID_AUCTION_OWNER,
                array(
                    FieldIdEnum::USER_LOGIN                     =>  'admin',
                    FieldIdEnum::AUCTION_TITLE                  =>  'Auction 5',
                    ParamIdEnum::USER_FULLNAME                  =>  'Admin Adminowy',
                    ParamIdEnum::LINK                           =>  '/auction/show/5',
                    FieldIdEnum::TRANSACTION_NUMBER_OF_ITEMS    =>  '2',
                    FieldIdEnum::TRANSACTION_PRICE              =>  Formatter_Price::formatWithCurrency('122.12', 'PLN')
                )
            ),
            array(
                'Transaction/5_att_5_u_1',
                5,
                Enum_Db_Notification_Type::AUCTION_BID_OUTBIDDED,
                array(
                    FieldIdEnum::AUCTION_TITLE                  =>  'Auction 5',
                    ParamIdEnum::USER_FULLNAME                  =>  'Admin Adminowy',
                    ParamIdEnum::LINK                           =>  '/auction/show/5',
                    FieldIdEnum::TRANSACTION_NUMBER_OF_ITEMS    =>  '2',
                    FieldIdEnum::TRANSACTION_PRICE              =>  Formatter_Price::formatWithCurrency('122.12', 'PLN'),
                    ParamIdEnum::AUCTION_PRICE                  =>  Formatter_Price::formatWithCurrency('3210.12', 'PLN')
                )
            ),
        );
    }
    
    /**
     * @test
     * @dataProvider getRecipientsDataProvider
     */
    public function getRecipients($notificationType, $expectedRecipient)
    {
        $this->_loadFixtures(array(
            'Category/1',
            'Currency/1',
            'Auction/5_category_1_start_2012-05-02',
            'AuctionTransactionType/4_auction_5_tt_1',
            'AuctionTransactionType/5_auction_5_tt_2',
            'User/3_inactive',
            'Transaction/7_att_4_u_3'
        ));
        
        $this->assertEquals(array($expectedRecipient), TransactionTable::getInstance()->find(7)->getRecipients($notificationType));
    }
    
    public function getRecipientsDataProvider()
    {
        return array(
            array(Enum_Db_Notification_Type::AUCTION_BID_AUCTION_OWNER, 'lio_lio@wp.pl'),
            array(Enum_Db_Notification_Type::AUCTION_BID_BIDDER, 'user_inactive@email.com'),
            array(Enum_Db_Notification_Type::AUCTION_BID_OUTBIDDED, 'user_inactive@email.com')
        );
    }
    
    /**
     * @test
     */
    public function getRelatedObjectId()
    {
        $this->_loadFixtures(array(
            'Category/1',
            'Currency/1',
            'Auction/5_category_1_start_2012-05-02',
            'AuctionTransactionType/4_auction_5_tt_1',
            'AuctionTransactionType/5_auction_5_tt_2',
            'User/3_inactive',
            'Transaction/7_att_4_u_3'
        ));
        
        $this->assertEquals(7, TransactionTable::getInstance()->find(7)->getRelatedObjectId());
    }
}
