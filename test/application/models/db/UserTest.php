<?php
/**
 * @class UserTest
 */
class UserTest extends TestCase_Database
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
     */
    public function getNotificationData()
    {
        $this->assertEquals(
            array(
                FieldIdEnum::USER_LOGIN =>  'admin',
                ParamIdEnum::LINK       =>  FrontController_Link_Generator::generate(Enum_Db_Notification_Type::USER_REGISTRATION, '123qwe')
            ),
            $this->_user->getNotificationData(Enum_Db_Notification_Type::USER_REGISTRATION)
        );
    }
    
    /**
     * @test
     */
    public function getRecipients()
    {
        $this->assertEquals(
                array('lio_lio@wp.pl'),
                $this->_user->getRecipients()
        );
    }
}
