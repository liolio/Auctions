<?php
/**
 * @class Controller_Front_UrlGeneratorTest
 */
class Controller_Front_UrlGeneratorTest extends TestCase_NoDatabase
{
    
    /**
     * @test
     */
    public function generateWithoutAdditionalValue()
    {
        $this->assertEquals(
            Zend_Controller_Front::getInstance()->getBaseUrl() . "/register",
            Controller_Front_UrlGenerator::generate(Enum_Db_Notification_Type::USER_REGISTRATION)
        );
    }
    
    /**
     * @test
     * @dataProvider notificationTypeProvider
     */
    public function generateWithAdditionalValue($notificationType, $actionName)
    {
        $this->assertEquals(
            Zend_Controller_Front::getInstance()->getBaseUrl() . "/" . $actionName . "/additionalValue",
            Controller_Front_UrlGenerator::generate($notificationType, "additionalValue")
        );
    }
    
    public static function notificationTypeProvider()
    {
        return array(
            array(Enum_Db_Notification_Type::USER_REGISTRATION, 'register'),
            array(Enum_Db_Notification_Type::USER_PASSWORD_RESET, 'user/password-reset'),
            array(Enum_Db_Notification_Type::AUCTION_BID_AUCTION_OWNER, 'auction/show'),
            array(Enum_Db_Notification_Type::AUCTION_BUY_OUT_AUCTION_OWNER, 'auction/show'),
            array(Enum_Db_Notification_Type::AUCTION_BID_BIDDER, 'auction/show'),
            array(Enum_Db_Notification_Type::AUCTION_BUY_OUT_CUSTOMER, 'auction/show'),
            array(Enum_Db_Notification_Type::AUCTION_BID_OUTBIDDED, 'auction/show'),
            array(Enum_Db_Notification_Type::AUCTION_BID_WINNER, 'auction/show'),
            array(Enum_Db_Notification_Type::AUCTION_FINISHED_OWNER, 'auction/show'),
        );
    }
    
    /**
     * @test
     */
    public function generateWithInvalidNotificationType()
    {
        try
        {
            Controller_Front_UrlGenerator::generate("invalid");
            $this->fail("Invalid argument expected");
        }
        catch (InvalidArgumentException $ex)
        {
            $this->assertEquals('Notification type must be one of supported Enum_Db_Notification_Type. invalid is invalid.', $ex->getMessage());
        }
    }
}
