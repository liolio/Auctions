<?php
/**
 * @class Auth_AdapterTest
 */
class Auth_AdapterTest extends TestCase_Database
{
    
    /**
     * @test
     */
    public function authenticateWithValidCredentials()
    {
        $user = UserTable::getInstance()->findOneBy('login', 'admin');
        
        $adapter = new Auth_Adapter('admin', 'admin');
        $authernticationResult = $adapter->authenticate();
        
        $this->assertEquals(Auth_Result::SUCCESS, $authernticationResult->getCode());
        $this->assertEquals($user->id, $authernticationResult->getIdentity());
        $this->assertEmpty($authernticationResult->getMessages());
    }
    
    /**
     * @test
     */
    public function authenticateWithNotExistingUser()
    {
        $adapter = new Auth_Adapter('non_existing', 'wrong_password');
        $authernticationResult = $adapter->authenticate();
        
        $this->assertEquals(Auth_Result::FAILURE_IDENTITY_NOT_FOUND, $authernticationResult->getCode());
        $this->assertEquals('non_existing', $authernticationResult->getIdentity());
        $this->assertEmpty($authernticationResult->getMessages());
    }
    
    /**
     * @test
     */
    public function authenticateWithInvalidPassword()
    {
        $adapter = new Auth_Adapter('admin', 'wrong_password');
        $authernticationResult = $adapter->authenticate();
        
        $this->assertEquals(Auth_Result::FAILURE_CREDENTIAL_INVALID, $authernticationResult->getCode());
        $this->assertEquals('admin', $authernticationResult->getIdentity());
        $this->assertEmpty($authernticationResult->getMessages());
    }
    
    /**
     * @test
     */
    public function authenticateWithNotActiveUser()
    {
        Fixture_Factory::create('User/3_inactive');
        $adapter = new Auth_Adapter('user_inactive', 'admin');
        $authernticationResult = $adapter->authenticate();

        $this->assertEquals(Auth_Result::FAILURE_NOT_ACTIVE, $authernticationResult->getCode());
        $this->assertEquals('user_inactive', $authernticationResult->getIdentity());
        $this->assertEmpty($authernticationResult->getMessages());
    }
}
