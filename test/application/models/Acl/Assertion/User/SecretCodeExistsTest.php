<?php
/**
 * @class Acl_Assertion_User_SecretCodeExistsTest
 */
class Acl_Assertion_User_SecretCodeExistsTest extends TestCase_Database
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
        $this->_loadFixture('User/4_inactive_with_secret_code');
        $assertion = new Acl_Assertion_User_SecretCodeExists(array(FieldIdEnum::USER_SECRET_CODE => $login));
        $this->assertEquals($result, $assertion->assert($this->_acl));
    }
    
    public static function dataProvider()
    {
        return array(
            array('sercret1234', true),
            array('non_existing', false),
            array('', false),
            array(null, false),
        );
    }            
}
