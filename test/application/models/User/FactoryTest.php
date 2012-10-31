<?php
/**
 * @class User_FactoryTest
 */
class User_FactoryTest extends TestCase_NoDatabase
{

    /**
     * @test
     */
    public function create()
    {
        $login = 'some_login';
        $email = 'some_em@il.com';
        $securityCode = User_SecurityCode_Generator::generate();
        
        $user = User_Factory::create($login, $email, $securityCode);
        
        $this->assertEquals($login, $user->login);
        $this->assertEquals(str_repeat('0', 40), $user->password);
        $this->assertGreaterThanOrEqual(User::SALT_MIN, $user->salt);
        $this->assertLessThanOrEqual(User::SALT_MAX, $user->salt);
        $this->assertEquals($securityCode, $user->secret_code);
        $this->assertEquals($email, $user->email);
        $this->assertFalse($user->active);
    }
}
