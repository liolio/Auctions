<?php
/**
 * @class Acl_Assertion_Container_OrTest
 */
class Acl_Assertion_Container_OrTest extends TestCase_Database
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
    public function assert(array $params, $result)
    {
        Fixture_Loader::create('User/4_inactive_with_secret_code');
        
        $assertionContainer = new Acl_Assertion_Container_Or();
        $assertionContainer->addAssertion(new Acl_Assertion_User_LoginExists($params));
        $assertionContainer->addAssertion(new Acl_Assertion_User_SecretCodeExists($params));
        
        $this->assertEquals($result, $assertionContainer->assert($this->_acl));
    }
    
    public static function dataProvider()
    {
        return array(
            //both ok
            array(
                array(
                    FieldIdEnum::USER_LOGIN         =>  'user_inactive_with_secret_code',
                    FieldIdEnum::USER_SECRET_CODE   =>  'sercret1234'
                ),
                true
            ),
            //invalid second
            array(
                array(
                    FieldIdEnum::USER_LOGIN         =>  'user_inactive_with_secret_code',
                    FieldIdEnum::USER_SECRET_CODE   =>  'invalid'
                ),
                true
            ),
            //missing second
            array(
                array(
                    FieldIdEnum::USER_LOGIN         =>  'user_inactive_with_secret_code',
                ),
                true
            ),
            //invalid first
            array(
                array(
                    FieldIdEnum::USER_LOGIN         =>  'invalid',
                    FieldIdEnum::USER_SECRET_CODE   =>  'sercret1234'
                ),
                true
            ),
            //missing first
            array(
                array(
                    FieldIdEnum::USER_SECRET_CODE   =>  'sercret1234'
                ),
                true
            ),
            //invalid both
            array(
                array(
                    FieldIdEnum::USER_LOGIN         =>  'invalid',
                    FieldIdEnum::USER_SECRET_CODE   =>  'invalid'
                ),
                false
            ),
            //missing both
            array(
                array(),
                false
            ),
        );
    }
}
