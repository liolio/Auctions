<?php
/**
 * @class Enum_Acl_ResourceTest
 */
class Enum_Acl_ResourceTest extends TestCase_NoDatabase
{
    
    /**
     * @test
     */
    public function checkAmount()
    {
        $this->assertEquals(15, count(Enum_Acl_Resource::getEnums()));
    }
    
    /**
     * @test
     * @dataProvider controllerNameProvider
     */
    public function getControllerName($enum, $controller)
    {
        $this->assertEquals($controller, Enum_Acl_Resource::getControllerName($enum));
    }
    
    public function controllerNameProvider() {
        return array(
            array(Enum_Acl_Resource::ADDRESS, "address"),
            array(Enum_Acl_Resource::ADMINISTRATOR, "administrator"),
            array(Enum_Acl_Resource::AUCTION, "auction"),
            array(Enum_Acl_Resource::AUTH, "auth"),
            array(Enum_Acl_Resource::BANKING_INFORMATION, "banking-information"),
            array(Enum_Acl_Resource::CATEGORY, "category"),
            array(Enum_Acl_Resource::CURRENCY, "currency"),
            array(Enum_Acl_Resource::DELIVERY_FORM, "delivery-form"),
            array(Enum_Acl_Resource::DELIVERY_TYPE, "delivery-type"),
            array(Enum_Acl_Resource::ERROR, "error"),
            array(Enum_Acl_Resource::FILE, "file"),
            array(Enum_Acl_Resource::INDEX, "index"),
            array(Enum_Acl_Resource::NEWS, "news"),
            array(Enum_Acl_Resource::TRANSACTION, "transaction"),
            array(Enum_Acl_Resource::USER, "user")
        );
    }
    
}
