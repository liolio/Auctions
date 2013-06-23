<?php
/**
 * @class Auctions_Form_DeliveryForm_ProcessTest
 */
class Auctions_Form_DeliveryForm_ProcessTest extends TestCase_NoDatabase
{
 
    /**
     * @var Auctions_Form_DeliveryForm_Process
     */
    private $_form;
    
    protected function setUp()
    {
        parent::setUp();
        
        $this->_form = new Auctions_Form_DeliveryForm_Process();
    }
    
     /**
     * @test
     */
    public function isValidWithValidValues()
    {
        $this->assertTrue($this->_form->isValid(array(
            FieldIdEnum::DELIVERY_FORM_ID               =>  '1',
            ParamIdEnum::DELIVERY_FORM_IS_PROCESSED     =>  '1',
        )));
    }
    
    /**
     * @test
     */
    public function isValidWithInvalidValues()
    {
        $this->assertFalse($this->_form->isValid(array()));
        
        $this->assertEquals(
            array(
                FieldIdEnum::DELIVERY_FORM_ID           =>  array(Validate_NotEmpty::IS_EMPTY),
                ParamIdEnum::DELIVERY_FORM_IS_PROCESSED =>  array(),
                ParamIdEnum::FORM_SAVE_BUTTON           =>  array()
            ), 
            $this->_form->getErrors()
        );
    }
    
}
