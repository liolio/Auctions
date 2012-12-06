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
     */
    public function generateWithAdditionalValue()
    {
        $this->assertEquals(
            Zend_Controller_Front::getInstance()->getBaseUrl() . "/register/additionalValue",
            Controller_Front_UrlGenerator::generate(Enum_Db_Notification_Type::USER_REGISTRATION, "additionalValue")
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
            $this->assertEquals('Notification type must be one of Enum_Db_Notification_Type', $ex->getMessage());
        }
    }
}
