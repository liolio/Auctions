<?php
/**
 * @class Acl_Assertion_FlyweightTest
 */
class Acl_Assertion_FlyweightTest extends TestCase_Database
{
    
    /**
     * @test
     * @dataProvider validDataProvider
     */
    public function getAssertionWithValidValue(array $params, $assertionName, Zend_Acl_Assert_Interface $expectedClass)
    {
        $request = new Zend_Controller_Request_Http();
        $request->setParams($params);
        
        $assertionFlyweight = new Acl_Assertion_Flyweight($request);
        $this->assertTrue($assertionFlyweight->getAssertion($assertionName) instanceof $expectedClass);
    }
    
    public static function validDataProvider()
    {
        $params = array(
            FieldIdEnum::USER_SECRET_CODE   =>  'secret_code',
            FieldIdEnum::USER_LOGIN         =>  'login'
        );
        
        return array(
            array($params, Acl_Assertion_User_SecretCodeExists::getClassName(), new Acl_Assertion_User_SecretCodeExists($params)),
            array($params, Acl_Assertion_User_LoginExists::getClassName(), new Acl_Assertion_User_LoginExists($params))
        );
    }
    
    /**
     * @test
     * @dataProvider invalidDataProvider
     */
    public function getAssertionWithInvalidValue($assertionName)
    {
        $assertionFlyweight = new Acl_Assertion_Flyweight(new Zend_Controller_Request_Http());
        try
        {
            $assertionFlyweight->getAssertion($assertionName);
            $this->fail('InvalidArgumentException expected, nothing has been thrown.');
        }
        catch (InvalidArgumentException $ex)
        {
            $this->assertEquals('Assertion: ' . $assertionName . ' doesn\'t exist.', $ex->getMessage());
        }
    }
    
    public static function invalidDataProvider()
    {
        return array(
            array('non_existing'),
            array('')
        );
    }
}
