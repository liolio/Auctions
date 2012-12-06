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
        Auctions_Form_User_Registration::addReCaptcha(false);
        $userEmail = 'new_user@email.com';
        
        $this->_setRequest(array(
            FieldIdEnum::USER_LOGIN             =>  'newuser',
            FieldIdEnum::USER_EMAIL             =>  $userEmail,
            FieldIdEnum::ADDRESS_NAME           =>  'name',
            FieldIdEnum::ADDRESS_SURNAME        =>  'sur-name',
            FieldIdEnum::ADDRESS_STREET         =>  'street 1/1',
            FieldIdEnum::ADDRESS_POSTAL_CODE    =>  'postal 123',
            FieldIdEnum::ADDRESS_CITY           =>  'city',
            FieldIdEnum::ADDRESS_PROVINCE       =>  'province',
            FieldIdEnum::ADDRESS_COUNTRY        =>  'country',
            FieldIdEnum::ADDRESS_PHONE_NUMBER   =>  '123456890',
        ));
        
        $this->dispatch('/user/process-registration-form');
        $this->_assertDispatch('user', 'process-registration-form');
        $headers = $this->getResponse()->getHeaders();
        $this->assertEquals(Zend_Controller_Front::getInstance()->getBaseUrl() . '/', $headers[0]['value']);
        
        $now = Zend_Date::now()->toString(Time_Format::getFullDateTimeFormat());
        $user = UserTable::getInstance()->findOneBy('login', 'newuser');
        $this->assertTrue($user->exists());
        $this->assertNotEmpty($user->secret_code);
        $this->assertNotEmpty($user->salt);
        $this->assertFalse($user->active);
        $this->assertEquals($userEmail, $user->email);
        $this->_assertTime($now, $user->created_at);
        $this->_assertTime($now, $user->updated_at);
        
        $address = $user->Addresses->getFirst();
        $this->assertEquals('name', $address->name);
        $this->assertEquals('sur-name', $address->surname);
        $this->assertEquals('street 1/1', $address->street);
        $this->assertEquals('postal 123', $address->postal_code);
        $this->assertEquals('city', $address->city);
        $this->assertEquals('country', $address->country);
        $this->assertEquals('123456890', $address->phone_number);
        $this->assertEquals('province', $address->province);
        
        $messageBuilder = new Notification_Message_Builder($user, Enum_Db_Notification_Type::USER_REGISTRATION);
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
        $this->assertEquals(Enum_Db_Notification_Type::USER_REGISTRATION, $notification->type);
        $this->_assertTime($now, $notification->created_at);
        $this->_assertTime($now, $notification->updated_at);
        Auctions_Form_User_Registration::addReCaptcha(true);
    }
    
    /**
     * @test
     */
    public function processWithInvalidData()
    {
        $this->_setRequest(array());
        
        $this->dispatch('/user/process-registration-form');
        $this->_assertDispatch('user', 'process-registration-form');
        
        $this->assertContains("Value is required and can't be empty", $this->getResponse()->getBody());
    }
}
