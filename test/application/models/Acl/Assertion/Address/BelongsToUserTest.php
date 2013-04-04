<?php
/**
 * @class Acl_Assertion_Address_BelongsToUserTest
 */
class Acl_Assertion_Address_BelongsToUserTest extends TestCase_Controller
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
        $this->_loadFixtures(array(
            "User/4_inactive_with_secret_code",
            "Address/2_user_4"
        ));
        $assertion = new Acl_Assertion_Address_BelongsToUser(array(FieldIdEnum::ADDRESS_ID => $id));
        $this->assertEquals($result, $assertion->assert($this->_acl));
    }
    
    public static function dataProvider()
    {
        return array(
            array(1, true),
            array(2, false),
            array(null, false),
        );
    }    
}
