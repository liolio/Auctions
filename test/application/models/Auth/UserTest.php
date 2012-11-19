<?php
/**
 * @class Auth_UserTest
 */
class Auth_UserTest extends TestCase_Controller
{
    
    protected function setUp()
    {
        $this->_disableLoggingInAdminUser();
        parent::setUp();
        Auth_User::getInstance()->clearUser();
    }
    
    /**
     * @test
     */
    public function getLoggedUser()
    {
        $this->_logInAdminUser();
        $user = Auth_User::getInstance()->getUser();
        
        $this->assertEquals('admin', $user->login);
        $this->assertEquals(DbEnum_User_Role::ADMINISTRATOR, $user->role);
    }
    
    /**
     * @test
     */
    public function getNotLogged()
    {
        $this->assertNull(Auth_User::getInstance()->getUser());
    }
}
