<?php
/**
 * @class UserTest
 */
class UserTest extends TestCase_Database
{
    
    /**
     * @test 
     */
    public function checkPassword()
    {
        $user = UserTable::getInstance()->findOneBy('login', 'admin');
        $user->checkPassword('admin');
    }
}
