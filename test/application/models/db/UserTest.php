<?php
/**
 * @class UserTest
 */
class UserTest extends TestCase_Database
{
    
    /**
     * @test 
     * @dataProvider checkPasswordDataProvider
     */
    public function checkPassword($password, $result)
    {
        $user = UserTable::getInstance()->findOneBy('login', 'admin');
        $this->assertEquals($result, $user->checkPassword($password));
    }
    
    public static function checkPasswordDataProvider() 
    {
        return array(
            array('admin', true),
            array('invalid', false)
        );
    }
}
