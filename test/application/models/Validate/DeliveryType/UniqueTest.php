<?php
/**
 * @class Validate_DeliveryType_UniqueTest
 */
class Validate_DeliveryType_UniqueTest extends TestCase_Database
{
    
    /**
     * @var Validate_DeliveryType_Unique
     */
    private $_validator;
    
    protected function setUp()
    {
        parent::setUp();
        $this->_validator = new Validate_DeliveryType_Unique();
    }
    
    /**
     * @test
     * @dataProvider dataProvider
     */
    public function isValid($value, array $context, $expectedResult)
    {
        $this->_loadFixture("DeliveryType/1");
        $this->assertEquals($expectedResult, $this->_validator->isValid($value, $context));
    }
    
    public function dataProvider()
    {
        return array(
            array(
                "Poczta polska", 
                array(
                    FieldIdEnum::DELIVERY_TYPE_CASH_ON_DELIVERY =>  '1'
                ), 
                true
            ),
            array(
                "", 
                array(
                    FieldIdEnum::DELIVERY_TYPE_CASH_ON_DELIVERY =>  '1'
                ), 
                true
            ),
            array(
                "Kurier", 
                array(
                    FieldIdEnum::DELIVERY_TYPE_CASH_ON_DELIVERY =>  '0'
                ), 
                true
            ),
            array(
                "Kurier", 
                array(
                    FieldIdEnum::DELIVERY_TYPE_CASH_ON_DELIVERY =>  '1'
                ), 
                false
            ),
            array(
                "Kurier", 
                array(
                    FieldIdEnum::DELIVERY_TYPE_CASH_ON_DELIVERY =>  '1',
                    FieldIdEnum::DELIVERY_TYPE_ID               =>  '1'
                ), 
                true
            ),
        );
    }
}
