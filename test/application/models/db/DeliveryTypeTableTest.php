<?php
/**
 * @class DeliveryTypeTableTest
 */
class DeliveryTypeTableTest extends TestCase_Database
{
    
    /**
     * @test
     * @dataProvider dataProvider
     */
    public function isValid($name, $cashOnDelivery, $id, $expectedResult)
    {
        $this->_loadFixture("DeliveryType/1");
        $this->assertEquals($expectedResult, DeliveryTypeTable::getInstance()->isUnique($name, $cashOnDelivery, $id));
    }
    
    public function dataProvider()
    {
        return array(
            array(
                "Poczta polska", 
                "1",
                null,
                true
            ),
            array(
                "", 
                "1",
                null,
                true
            ),
            array(
                "Kurier", 
                "0",
                null,
                true
            ),
            array(
                "Kurier", 
                "1",
                null,
                false
            ),
            array(
                "Kurier", 
                "1",
                "1",
                true
            ),
        );
    }
    
    /**
     * @test
     */
    public function getIds()
    {
        $this->_loadFixtures(array(
            "DeliveryType/1",
            "DeliveryType/3",
            "DeliveryType/4",
        ));
        
        $this->assertEquals(array(3, 1, 4), DeliveryTypeTable::getInstance()->getIds());
    }
}
