<?php
/**
 * @class Acl_Assertion_User_LoginExistsTest
 */
class Acl_Assertion_User_LoginExistsTest extends TestCase_Database
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
        $assertion = new Acl_Assertion_User_LoginExists(array(FieldIdEnum::USER_LOGIN => $login));
        $this->assertEquals($result, $assertion->assert($this->_acl));
    }
    
    public static function dataProvider()
    {
        return array(
            array('admin', true),
            array('non_existing', false),
            array('', false),
            array(null, false),
        );
    }            
}
