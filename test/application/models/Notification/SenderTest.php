<?php
/**
 * @class Notification_SenderTest
 */
class Notification_SenderTest extends TestCase_Mail
{
    
    /**
     * @var Notification_Sender
     */
    private $_sender;
    
    protected function setUp()
    {
        parent::setUp();
        
        $this->_sender = new Notification_Sender();
    }
    
    /**
     * @test
     */
    public function send()
    {
        Fixture_Factory::create("User/4_inactive_with_secret_code");
        
        $user = UserTable::getInstance()->findOneBy('login', 'user_inactive_with_secret_code');
        
        $this->_sender->send($user, Enum_Db_Notification_Type::USER_REGISTRATION);
        $messageBuilder = new Notification_Message_Builder($user, Enum_Db_Notification_Type::USER_REGISTRATION);
        
        $this->_assertEmailFile(
            array('user_inactive_with_secret_code@email.com'),
            'lio_lio@wp.pl',
            $messageBuilder->buildSubjectForNotificationType(),
            $messageBuilder->buildBodyForNotificationType()
        );
    }
    
    /**
     * @test
     */
    public function sendWithInvalidNotificationType()
    {
        try
        {
            $this->_sender->send(new User(), 'invalid');
            $this->fail('Invalid argument exception expected;');
        }
        catch (InvalidArgumentException $ex)
        {
            $this->assertEquals(
                    'Notification type must be one of Enum_Db_Notification_Type enums.',
                    $ex->getMessage()
            );
        }
    }
    
}
