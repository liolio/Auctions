<?php
/**
 * @class UserTest
 */
class UserTest extends PHPUnit_Framework_TestCase
{
    
    /**
     * @test 
     */
    public function foo()
    {
        $this->assertEquals('qqq', UserTable::getInstance()->find(1)->foo());
    }
}
