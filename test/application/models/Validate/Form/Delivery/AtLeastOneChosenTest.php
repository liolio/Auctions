<?php
/**
 * @class Validate_Form_Delivery_AtLeastOneChosenTest
 */
class Validate_Form_Delivery_AtLeastOneChosenTest extends TestCase_Database
{
    
    /**
     * @var Validate_Form_Delivery_AtLeastOneChosen
     */
    private $_validator;
    
    protected function setUp()
    {
        parent::setUp();
        $this->_validator = new Validate_Form_Delivery_AtLeastOneChosen();
    }
    
    /**
     * @test
     * @dataProvider isValidDataProvider
     */
    public function isValid(array $formValues, $expectedValue)
    {
        $this->_loadFixtures(array(
            'DeliveryType/1',
            'DeliveryType/2',
        ));
        
        $this->assertEquals($expectedValue, $this->_validator->isValid($this->_getFilledForm($formValues)));
        
        $this->assertEquals(
            $expectedValue ?
                null :
                $this->_getTranslator()->translate('validation_message-delivery_at_least_one_not_chosen'),
            $this->_validator->getMessage()    
        );
    }
    
    public function isValidDataProvider()
    {
        return array(
            array(
                array(
                    FieldIdEnum::DELIVERY_TYPE_ID . '_1'   =>  '0',
                    FieldIdEnum::DELIVERY_TYPE_ID . '_2'   =>  '0'
                ),
                false
            ),
            array(
                array(
                    FieldIdEnum::DELIVERY_TYPE_ID . '_1'   =>  '1',
                    FieldIdEnum::DELIVERY_TYPE_ID . '_2'   =>  '0'
                ),
                true
            ),
            array(
                array(
                    FieldIdEnum::DELIVERY_TYPE_ID . '_1'   =>  '0',
                    FieldIdEnum::DELIVERY_TYPE_ID . '_2'   =>  '1'
                ),
                true
            ),
            array(
                array(
                    FieldIdEnum::DELIVERY_TYPE_ID . '_1'   =>  '1',
                    FieldIdEnum::DELIVERY_TYPE_ID . '_2'   =>  '1'
                ),
                true
            ),
        );
    }
    
    private function _getFilledForm(array $values)
    {
        $form = new Zend_Form();
        
        $form->addElement(new Form_Element_Select(FieldIdEnum::DELIVERY_TYPE_ID . '_1'));
        $form->addElement(new Form_Element_Select(FieldIdEnum::DELIVERY_TYPE_ID . '_2'));
        
        $form->isValid($values);
        
        return $form;
    }
}
