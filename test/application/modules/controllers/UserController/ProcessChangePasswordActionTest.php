<?php
/**
 * @class Auctions_UserController_ProcessChangePasswordActionTest
 */
class Auctions_UserController_ProcessChangePasswordActionTest extends TestCase_Mail
{
    
    /**
     * @test
     */
    public function process()
    {
        $this->_setRequest(array(
            FieldIdEnum::USER_LOGIN         =>  'admin',
            ParamIdEnum::OLD_PASSWORD       =>  'admin',
            FieldIdEnum::USER_PASSWORD      =>  'new_admin',
            ParamIdEnum::PASSWORD_REPEAT    =>  'new_admin'
        ));
        
        $this->dispatch('user/process-change-password');
        $this->_assertDispatch('user', 'process-change-password');
        
        $this->_assertRedirection("user/panel");
        
        $user = UserTable::getInstance()->findOneBy('login', 'admin');
        $this->assertTrue($user->checkPassword('new_admin'));
        
        $now = Zend_Date::now()->toString(Time_Format::getFullDateTimeFormat());
        
        $messageBuilder = new Notification_Message_Builder($user, Enum_Db_Notification_Type::USER_NEW_PASSWORD_SET);
        $this->_assertEmailFile(
                array($user->email), 
                'lio_lio@wp.pl', 
                $messageBuilder->buildSubjectForNotificationType(), 
                $messageBuilder->buildBodyForNotificationType()
        );
        
        $notifications = NotificationTable::getInstance()->findAll();
        $this->assertEquals(1, $notifications->count());
        
        $notification = $notifications->get(0);
        $this->assertEquals($user->id, $notification->related_object_id);
        $this->assertEquals(Enum_Db_Notification_Type::USER_NEW_PASSWORD_SET, $notification->type);
        $this->_assertTime($now, $notification->created_at);
        $this->_assertTime($now, $notification->updated_at);
    }
    
    /**
     * @test
     */
    public function processWithInvalidData()
    {
        $this->_setRequest(array(
            FieldIdEnum::USER_LOGIN         =>  'admin',
        ));
        
        $this->dispatch('/user/process-change-password');
        $this->_assertDispatch('user', 'process-change-password');
        
        $this->assertContains($this->_getTranslator()->translate('validation_message-field_empty'), $this->getResponse()->getBody());
    }
    
    /**
     * @test
     */
    public function processWithAclFailure()
    {
        $this->_setRequest(array());
        
        $this->dispatch('/user/process-change-password');
        $this->_assertAclDeny();
    }
}
