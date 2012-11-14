<?php
/**
 * @class Auctions_UserController_ProcessRegistrationFormActionTest
 */
class Auctions_UserController_ProcessRegistrationFormActionTest extends TestCase_Mail
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
        $userLogin = 'new_user';
        $userEmail = 'new_user@email.com';
        
        $this->_setRequest(array(
            FieldIdEnum::USER_LOGIN => $userLogin,
            FieldIdEnum::USER_EMAIL => $userEmail
        ));
        
        $this->dispatch('/user/process-registration-form');
        $this->_assertDispatch('user', 'process-registration-form');
        $headers = $this->getResponse()->getHeaders();
        $this->assertEquals(Zend_Controller_Front::getInstance()->getBaseUrl() . '/', $headers[0]['value']);
        
        $now = Zend_Date::now()->toString(Time_Format::getFullDateTimeFormat());
        $user = UserTable::getInstance()->findOneBy('login', $userLogin);
        $this->assertTrue($user->exists());
        $this->assertNotEmpty($user->secret_code);
        $this->assertNotEmpty($user->salt);
        $this->assertFalse($user->active);
        $this->assertEquals($userEmail, $user->email);
        $this->_assertTime($now, $user->created_at);
        $this->_assertTime($now, $user->updated_at);
        
        $messageBuilder = new Notification_Message_Builder($user, DbEnum_Notification_Type::USER_REGISTRATION);
        $this->_assertEmailFile(
                array($userEmail), 
                'lio_lio@wp.pl', 
                $messageBuilder->buildSubjectForNotificationType(), 
                $messageBuilder->buildBodyForNotificationType()
        );
        
        $notifications = NotificationTable::getInstance()->findAll();
        $this->assertEquals(1, $notifications->count());
        
        $notification = $notifications->get(0);
        $this->assertEquals($user->id, $notification->related_object_id);
        $this->assertEquals(DbEnum_Notification_Type::USER_REGISTRATION, $notification->type);
        $this->_assertTime($now, $notification->created_at);
        $this->_assertTime($now, $notification->updated_at);
    }
    
    /**
     * @test
     */
    public function processWithMissingData()
    {
        $this->_setRequest(array());
        
        $this->dispatch('/user/process-registration-form');
        $this->_assertDispatch('user', 'process-registration-form');
        
        $this->assertContains("Value is required and can't be empty", $this->getResponse()->getBody());
    }
    
    /**
     * @test
     */
    public function processWithNotUniqueData()
    {
        $this->_setRequest(array(
            FieldIdEnum::USER_LOGIN => 'admin',
            FieldIdEnum::USER_EMAIL => 'lio_lio@wp.pl'
        ));
        
        $this->dispatch('/user/process-registration-form');
        $this->_assertDispatch('user', 'process-registration-form');
        
        $response = $this->getResponse()->getBody();
        $this->assertContains($this->_getTranslator()->translate('validation_message-user_login_exists'), $response);
        $this->assertContains($this->_getTranslator()->translate('validation_message-user_email_exists'), $response);
    }
}
