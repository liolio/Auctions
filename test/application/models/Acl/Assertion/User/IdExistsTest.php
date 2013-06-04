<?php
/**
 * @class Acl_Assertion_User_IdExistsTest
 */
class Acl_Assertion_User_IdExistsTest extends TestCase_Database
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
    public function assertWithValidData($id, $result)
    {
        $assertion = new Acl_Assertion_User_IdExists(array(FieldIdEnum::USER_ID => $id));
        $this->assertEquals($result, $assertion->assert($this->_acl));
    }
    
    public static function dataProvider()
    {
        return array(
            array(1, true),
            array('1', true),
            array('100', false),
            array('', false),
            array(null, false),
        );
    }            
}
