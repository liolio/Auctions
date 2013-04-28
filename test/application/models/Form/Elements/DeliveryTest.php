<?php
/**
 * @class Form_Elements_DeliveryTest
 */
class Form_Elements_DeliveryTest extends TestCase_Database
{
    
    /**
     * @var Form_Elements_Delivery
     */
    private $_formElements;
    
    protected function setUp()
    {
        parent::setUp();
        $this->_loadFixtures(array(
            'DeliveryType/1',
            'DeliveryType/2',
            'DeliveryType/3',
            'DeliveryType/4'
        ));
        
        $this->_formElements = new Form_Elements_Delivery();
    }
    
    /**
     * @test
     */
    public function getCashOnDeliveryElements()
    {
        $fields = array();
        
        foreach ($this->_formElements->getCashOnDeliveryElements() as $element)
            $fields[$element->getName()] = array_keys($element->getValidators());
        
        $expectedFields = array(
            FieldIdEnum::DELIVERY_PRICE . "_1"      =>  array(
                'Validate_NotEmpty',
                'Validate_StringLength',
                'Validate_Float'
            ),
            FieldIdEnum::DELIVERY_PRICE . "_4"      =>  array(
                'Validate_NotEmpty',
                'Validate_StringLength',
                'Validate_Float'
            ),
            FieldIdEnum::DELIVERY_TYPE_ID . "_1"    =>  array(),
            FieldIdEnum::DELIVERY_TYPE_ID . "_4"    =>  array(),
        );
        
        $this->assertEquals($expectedFields, $fields);
    }
    
    /**
     * @test
     */
    public function getCashByTransferElements()
    {
        $fields = array();
        
        foreach ($this->_formElements->getCashByTransferElements() as $element)
            $fields[$element->getName()] = array_keys($element->getValidators());
        
        $expectedFields = array(
            FieldIdEnum::DELIVERY_PRICE . "_2"      =>  array(
                'Validate_NotEmpty',
                'Validate_StringLength',
                'Validate_Float'
            ),
            FieldIdEnum::DELIVERY_PRICE . "_3"      =>  array(
                'Validate_NotEmpty',
                'Validate_StringLength',
                'Validate_Float'
            ),
            FieldIdEnum::DELIVERY_TYPE_ID . "_2"    =>  array(),
            FieldIdEnum::DELIVERY_TYPE_ID . "_3"    =>  array(),
        );
        
        $this->assertEquals($expectedFields, $fields);
    }
}
