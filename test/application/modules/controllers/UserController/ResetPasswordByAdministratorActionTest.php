<?php
/**
 * @class Auctions_UserController_ResetPasswordByAdministratorActionTest
 */
class Auctions_UserController_ResetPasswordByAdministratorActionTest extends TestCase_Mail
{

    /**
     * @test
     */
    public function process()
    {
        $this->_setRequest(array(
            FieldIdEnum::USER_ID =>  '1',
        ));
        
        $this->dispatch('/user/reset-password-by-administrator/1');
        
        $this->_assertDispatch('user', 'reset-password-by-administrator');
        $this->_assertRedirection("user/show-list");
        
        $user = UserTable::getInstance()->find(1);
        $this->assertEquals(40, strlen($user->secret_code));
        
        $messageBuilder = new Notification_Message_Builder($user, Enum_Db_Notification_Type::USER_PASSWORD_RESET);
        $this->_assertEmailFile(
                array('lio_lio@wp.pl'), 
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
        
        $this->assertEquals(ParamIdEnum::WINDOW_PASSWORD_RESET_REQUEST_ADMIN, Session_DialogWindow::getValue());
    }
    
}
