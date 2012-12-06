<?php
/**
 * @class FrontController_Link_Generator
 */
class FrontController_Link_GeneratorTest extends TestCase_NoDatabase
{
    
    /**
     * @test
     */
    public function generateWithoutAdditionalValue()
    {
        $this->assertEquals(
            Zend_Controller_Front::getInstance()->getBaseUrl() . "/register",
            FrontController_Link_Generator::generate(Enum_Db_Notification_Type::USER_REGISTRATION)
        );
    }
    
    /**
     * @test
     */
    public function generateWithAdditionalValue()
    {
        $this->assertEquals(
            Zend_Controller_Front::getInstance()->getBaseUrl() . "/register/additionalValue",
            FrontController_Link_Generator::generate(Enum_Db_Notification_Type::USER_REGISTRATION, "additionalValue")
        );
    }
    
    /**
     * @test
     */
    public function generateWithInvalidNotificationType()
    {
        try
        {
            FrontController_Link_Generator::generate("invalid");
            $this->fail("Invalid argument expected");
        }
        catch (InvalidArgumentException $ex)
        {
            $this->assertEquals('Notification type must be one of Enum_Db_Notification_Type', $ex->getMessage());
        }
    }
}
