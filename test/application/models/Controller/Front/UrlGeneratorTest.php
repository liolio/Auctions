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
    public function generateWithAdditionalValue($type, $actionName)
    {
        $this->assertEquals(
            Zend_Controller_Front::getInstance()->getBaseUrl() . "/" . $actionName . "/additionalValue",
            Controller_Front_UrlGenerator::generate($type, "additionalValue")
        );
    }
    
    public static function notificationTypeProvider()
    {
        return array(
            array(Controller_Front_UrlGenerator::USER_REGISTRATION, 'register'),
            array(Controller_Front_UrlGenerator::USER_PASSWORD_RESET, 'user/password-reset'),
            array(Controller_Front_UrlGenerator::AUCTION_SHOW, 'auction/show'),
            array(Controller_Front_UrlGenerator::DELIVERY_FORM_FILL, 'delivery-form/fill'),
            array(Controller_Front_UrlGenerator::USER_PANEL_DELIVERIES, 'user/panel/deliveries'),
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
            $this->assertEquals('Type must be one of supported consts. invalid is invalid.', $ex->getMessage());
        }
    }
}
