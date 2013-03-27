<?php
/**
 * @class Acl_Assertion_BankingInformation_BelongsToUserTest
 */
class Acl_Assertion_BankingInformation_BelongsToUserTest extends TestCase_Controller
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
        Fixture_Loader::create("Currency/1");
        Fixture_Loader::create("User/2");
        Fixture_Loader::create("BankingInformation/1_currency_1_user_1");
        Fixture_Loader::create("BankingInformation/2_currency_1_user_2");
        
        $assertion = new Acl_Assertion_BankingInformation_BelongsToUser(array(FieldIdEnum::BANKING_INFORMATION_ID => $id));
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
