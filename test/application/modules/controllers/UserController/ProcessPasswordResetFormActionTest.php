<?php
/**
 * @class Auctions_UserController_ProcessPasswordResetFormActionTest
 */
class Auctions_UserController_ProcessPasswordResetFormActionTest extends TestCase_Mail
{
    
    protected function setUp()
    {
        $this->_disableLoggingInAdminUser();
        parent::setUp();
    }
    
    /**
     * @test
     */
    public function process()
    {
        $userEmail = 'lio_lio@wp.pl';
        
        $this->_setRequest(array(
            FieldIdEnum::USER_EMAIL =>  $userEmail,
        ));
        
        $this->dispatch('/user/process-password-reset-form');
        $this->_assertDispatch('user', 'process-password-reset-form');
        
        $this->assertRedirect();
        $headers = $this->getResponse()->getHeaders();
        $this->assertEquals(Zend_Controller_Front::getInstance()->getBaseUrl() . '/', $headers[0]['value']);
        
        $user = UserTable::getInstance()->findOneBy('email', $userEmail);
        $this->assertEquals(40, strlen($user->secret_code));
        
        $messageBuilder = new Notification_Message_Builder($user, Enum_Db_Notification_Type::USER_PASSWORD_RESET);
        $this->_assertEmailFile(
                array($userEmail), 
                'lio_lio@wp.pl', 
                $messageBuilder->buildSubjectForNotificationType(), 
                $messageBuilder->buildBodyForNotificationType()
        );
        
        $notifications = NotificationTable::getInstance()->findAll();
        $this->assertEquals(1, $notifications->count());
        
        $notification = $notifications->get(0);
        $now = Zend_Date::now()->toString(Time_Format::getFullDateTimeFormat());
        $this->assertEquals($user->id, $notification->related_object_id);
        $this->assertEquals(Enum_Db_Notification_Type::USER_PASSWORD_RESET, $notification->type);
        $this->_assertTime($now, $notification->created_at);
        $this->_assertTime($now, $notification->updated_at);
    }
    
    /**
     * @test
     */
    public function processWithInvalidData()
    {
        $this->_setRequest(array());
        
        $this->dispatch('/user/process-password-reset-form');
        $this->_assertDispatch('user', 'process-password-reset-form');
        
        $this->assertContains("Value is required and can't be empty", $this->getResponse()->getBody());
    }
}
