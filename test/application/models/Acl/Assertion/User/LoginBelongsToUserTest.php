<?php
/**
 * @class Acl_Assertion_User_LoginBelongsToUserTest
 */
class Acl_Assertion_User_LoginBelongsToUserTest extends TestCase_Controller
{
    
    /**
     * @var Zend_Acl
     */
    private $_acl;

    protected function setUp()
    {
        parent::setUp();
        $this->_acl = new Zend_Acl();
    }

    /**
     * @test
     * @dataProvider dataProvider
     */
    public function assertWithValidData($login, $result)
    {
        Fixture_Loader::create('user/2');
        $assertion = new Acl_Assertion_User_LoginBelongsToUser(array(FieldIdEnum::USER_LOGIN => $login));
        $this->assertEquals($result, $assertion->assert($this->_acl));
    }
    
    public static function dataProvider()
    {
        return array(
            array('admin', true),
            array('user', false),
            array('non_existing', false),
            array('', false),
            array(null, false),
        );
    }     
}
