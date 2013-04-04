<?php
/**
 * @class UserTableTest
 */
class UserTableTest extends TestCase_Database
{

    /**
     * @test
     * @dataProvider uniqueEmailProvider
     */
    public function isEmailUnique($email, $userId, $expectedResult)
    {
        $this->_loadFixture('User/2');
        $this->assertEquals($expectedResult, UserTable::getInstance()->isEmailUnique($email, $userId));
    }
    
    public function uniqueEmailProvider()
    {
        return array(
            array("unique@email.com", null, true),
            array("user@email.com", 2, true),
            
            array("user@email.com", null, false),
            array("user@email.com", 1, false),
        );
    }

    /**
     * @test
     * @dataProvider uniqueLoginProvider
     */
    public function isLoginUnique($login, $userId, $expectedResult)
    {
        $this->_loadFixture('User/2');
        $this->assertEquals($expectedResult, UserTable::getInstance()->isLoginUnique($login, $userId));
    }
    
    public function uniqueLoginProvider()
    {
        return array(
            array("unique", null, true),
            array("user", 2, true),
            
            array("user", null, false),
            array("user", 1, false),
        );
    }
}
