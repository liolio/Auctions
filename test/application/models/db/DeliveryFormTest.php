<?php
/**
 * @class DeliveryFormTest
 */
class DeliveryFormTest extends TestCase_Controller
{
    
    /**
     * @test
     * @dataProvider getNotificationDataDataProvider
     */
    public function getNotificationData($notificationType, array $expectedResult)
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
        
        $this->assertEquals(
            $expectedResult,
            DeliveryFormTable::getInstance()->find(1)->getNotificationData($notificationType)
        );
    }
    
    public function getNotificationDataDataProvider()
    {
        return array(
            array(
                Enum_Db_Notification_Type::DELIVERY_FROM_FILLED_AUCTION_OWNER,
                array(
                    FieldIdEnum::USER_LOGIN                     =>  'admin',
                    ParamIdEnum::USER_FULLNAME                  =>  'Admin Adminowy',
                    FieldIdEnum::AUCTION_TITLE                  =>  'Auction 1',
                    ParamIdEnum::LINK                           =>  '/auction/show/1',
                    FieldIdEnum::ADDRESS_NAME                   =>  'Admin',
                    FieldIdEnum::ADDRESS_SURNAME                =>  'Adminowy',
                    FieldIdEnum::ADDRESS_STREET                 =>  'Ulica 2',
                    FieldIdEnum::ADDRESS_POSTAL_CODE            =>  '30-002',
                    FieldIdEnum::ADDRESS_CITY                   =>  'KrakÃ³w',
                    FieldIdEnum::ADDRESS_PROVINCE               =>  'MaÅ‚opolskie',
                    FieldIdEnum::ADDRESS_COUNTRY                =>  'Polska',
                    FieldIdEnum::ADDRESS_PHONE_NUMBER           =>  '654987321',
                    FieldIdEnum::DELIVERY_FORM_COMMENT          =>  'some comment',
                    FieldIdEnum::TRANSACTION_PRICE              =>  'PLN 122.12',
                    FieldIdEnum::DELIVERY_TYPE_NAME             =>  'Kurier',
                    FieldIdEnum::DELIVERY_PRICE                 =>  'PLN 1.22',
                    FieldIdEnum::DELIVERY_TYPE_CASH_ON_DELIVERY =>  '<font color=\'green\'>Tak</font>',
                    ParamIdEnum::LINK2                          =>  '/user/panel/deliveries',
                )
            ),
        );
    }
    
    /**
     * @test
     * @dataProvider getRecipientsDataProvider
     */
    public function getRecipients($notificationType, array $expectedResult)
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
        
        $this->assertEquals(
            $expectedResult,
            DeliveryFormTable::getInstance()->find(1)->getRecipients($notificationType)
        );
    }
    
    public function getRecipientsDataProvider()
    {
        return array(
            array(
                Enum_Db_Notification_Type::DELIVERY_FROM_FILLED_AUCTION_OWNER,
                array('lio_lio@wp.pl')
            ),
        );
    }
    
    /**
     * @test
     */
    public function getRelatedObjectId()
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
    
        $this->assertEquals(1, DeliveryFormTable::getInstance()->find(1)->getRelatedObjectId());
    }
}
