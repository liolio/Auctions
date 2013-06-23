<?php
/**
 * @class UserTest
 */
class UserTest extends TestCase_Controller
{
    
    /**
     * @var User
     */
    private $_user;
    
    protected function setUp()
    {
        parent::setUp();
        $this->_user = UserTable::getInstance()->findOneBy('login', 'admin');
    }
    
    /**
     * @test 
     * @dataProvider checkPasswordDataProvider
     */
    public function checkPassword($password, $result)
    {
        $this->assertEquals($result, $this->_user->checkPassword($password));
    }
    
    public static function checkPasswordDataProvider() 
    {
        return array(
            array('admin', true),
            array('invalid', false)
        );
    }
    
    /**
     * @test
     */
    public function updateLastLogin()
    {
        $this->_user->updateLastLogin();
        $this->_user->refresh();
        
        $this->_assertTime(Zend_Date::now(), $this->_user->last_login);
    }
    
    /**
     * @test
     */
    public function getRelatedObjectId()
    {
        $this->assertEquals(1, UserTable::getInstance()->findOneBy('id', 1)->getRelatedObjectId());
    }
    
    /**
     * @test
     * @dataProvider notificationDataProvider
     */
    public function getNotificationData($notificationType, $expectedData)
    {
        $this->assertEquals($expectedData, $this->_user->getNotificationData($notificationType));
    }
    
    public function notificationDataProvider()
    {
        return array(
            array(
                Enum_Db_Notification_Type::USER_REGISTRATION, 
                array(
                    FieldIdEnum::USER_LOGIN     =>  'admin',
                    ParamIdEnum::USER_FULLNAME  =>  'Admin Adminowy',
                    ParamIdEnum::LINK           =>  '/register/123qwe'
                )
            ),
            array(
                Enum_Db_Notification_Type::USER_PASSWORD_RESET, 
                array(
                    FieldIdEnum::USER_LOGIN     =>  'admin',
                    ParamIdEnum::USER_FULLNAME  =>  'Admin Adminowy',
                    ParamIdEnum::LINK           =>  '/user/password-reset/123qwe'
                )
            ),
            array(
                Enum_Db_Notification_Type::USER_NEW_PASSWORD_SET,
                array(
                    FieldIdEnum::USER_LOGIN     =>  'admin',
                    ParamIdEnum::USER_FULLNAME  =>  'Admin Adminowy'
                )
            )
        );
    }
    
    /**
     * @test
     */
    public function setNewSecretCode()
    {
        $this->_user->resetSecretCode()->save();
        $this->assertNull($this->_user->secret_code);
        $this->_user->setNewSecretCode();
        $this->assertEquals(40, strlen($this->_user->secret_code));
    }
    
    /**
     * @test
     */
    public function getRecipients()
    {
        $this->assertEquals(
                array('lio_lio@wp.pl'),
                $this->_user->getRecipients('notImportant')
        );
    }
    
    /**
     * @test
     */
    public function getFullName()
    {
        $this->assertEquals("Admin Adminowy", $this->_user->getFullName());
    }
    
    /**
     * @test
     */
    public function getBankingInformationsForNotifications()
    {
        $this->_loadFixtures(array(
            'Currency/1',
            'BankingInformation/1_currency_1_user_1',
            'BankingInformation/3_currency_1_user_1',
        ));
        
        $expected = "<ul>" .
                "<li><strong>123 432 6456 7657</strong> polski bank (PLN)</li>" .
                "<li><strong>333 333 333 333</strong> polski bank (PLN)</li>" .
                "</ul>";
                
        $this->_user->refresh(true);
        
        $this->assertEquals($expected, $this->_user->getBankingInformationsForNotifications());
    }
    
    /**
     * @test
     */
    public function getBankingInformationsForNotificationsForUserWithoutBankingInformations()
    {
        $this->_loadFixture("User/2");
        
        $this->assertEquals(
            $this->_getTranslator()->translate('message-notification_no_banking_informations'), 
            UserTable::getInstance()->find(2)->getBankingInformationsForNotifications()
        );
    }
}
