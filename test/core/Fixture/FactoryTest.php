<?php
/**
 * @class Fixture_FactoryTest
 */
class Fixture_FactoryTest extends TestCase_Database
{
    
    /**
     * @test
     */
    public function createWithValidPathname()
    {
        Fixture_Factory::create("User/2");
        $this->assertTrue(UserTable::getInstance()->findAll()->count() > 1);
        
        $user = UserTable::getInstance()->findOneBy('login', 'user');
        $this->assertTrue($user->exists());
        die;
    }
    
    /**
     * @test
     */
    public function createWithInvalidPathname()
    {
        try {
            Fixture_Factory::create("User/21");
            $this->fail('No such file or directory expected');
        } catch (Exception $ex)
        {
            $this->assertContains('failed to open stream: No such file or directory', $ex->getMessage());
        }
    }
}
