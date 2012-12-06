<?php
/**
 * @class Notification_Message_BuilderTest
 */
class Notification_Message_BuilderTest extends TestCase_NoDatabase
{
    
    /**
     * @test
     */
    public function constructWithInvalidNotificationType()
    {
        try
        {
            new Notification_Message_Builder(new User(), "invalid");
            $this->fail("Invalid argument exception expected.");
        }
        catch (InvalidArgumentException $ex)
        {
            $this->assertEquals('Notification type must be one of Enum_Db_Notification_Type enums.', $ex->getMessage());
        }
    }
    
    /**
     * @test
     */
    public function buildBodyForNotificationType()
    {
        $user = new User();
        $user->login = "User Login";
        $user->secret_code = "S3CR3TC0D3";
        
        $builder = new Notification_Message_Builder($user, Enum_Db_Notification_Type::USER_REGISTRATION);
        $body = $builder->buildBodyForNotificationType();
        
        $this->assertContains("Witaj", $body);
        $this->assertContains($user->login, $body);
        $this->assertContains($user->secret_code, $body);
    }
    
    /**
     * @test
     */
    public function buildSubjectForNotificationType()
    {
        $user = new User();
        $user->login = "User Login";
        $user->secret_code = "S3CR3TC0D3";
        
        $builder = new Notification_Message_Builder($user, Enum_Db_Notification_Type::USER_REGISTRATION);
        
        $this->assertContains("Rejestracja", $builder->buildSubjectForNotificationType());
    }
}
