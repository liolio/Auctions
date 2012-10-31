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
}
