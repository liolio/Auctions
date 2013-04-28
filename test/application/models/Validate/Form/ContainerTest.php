<?php
/**
 * @class Validate_Form_ContainerTest
 */
class Validate_Form_ContainerTest extends TestCase_Database
{
    
    protected function setUp()
    {
        parent::setUp();
    }
    
    /**
     * @test
     * @dataProvider isValidDataProvider
     */
    public function isValid($mode, array $formValues, $expectedValue, $expectedMessage)
    {
        $this->_loadFixtures(array(
            'DeliveryType/1',
            'DeliveryType/2',
        ));
        
        $container = new Validate_Form_Container($mode);
        $container->addValidator(new Validate_Form_AuctionTransactionType_AtLeastOneChosen());
        $container->addValidator(new Validate_Form_Delivery_AtLeastOneChosen());
        
        $this->assertEquals($expectedValue, $container->isValid($this->_getFilledForm($formValues)));
        
        $this->assertEquals($expectedMessage, $container->getMessage());
    }
    
    public function isValidDataProvider()
    {
        return array(
            
        // MODE AND
            // both invalid
            array(
                Validate_Form_Container::MODE_AND,
                array(
                    ParamIdEnum::AUCTION_TRANSACTION_TYPE_BIDDING   =>  '0',
                    ParamIdEnum::AUCTION_TRANSACTION_TYPE_BUY_OUT   =>  '0',
                    FieldIdEnum::DELIVERY_TYPE_ID . '_1'            =>  '0',
                    FieldIdEnum::DELIVERY_TYPE_ID . '_2'            =>  '0'
                ),
                false,
                $this->_getTranslator()->translate('validation_message-auction_transaction_type_at_least_one_not_chosen') . "<BR/>" .
                $this->_getTranslator()->translate('validation_message-delivery_at_least_one_not_chosen')
            ),
            // first invalid
            array(
                Validate_Form_Container::MODE_AND,
                array(
                    ParamIdEnum::AUCTION_TRANSACTION_TYPE_BIDDING   =>  '0',
                    ParamIdEnum::AUCTION_TRANSACTION_TYPE_BUY_OUT   =>  '0',
                    FieldIdEnum::DELIVERY_TYPE_ID . '_1'            =>  '1',
                    FieldIdEnum::DELIVERY_TYPE_ID . '_2'            =>  '0'
                ),
                false,
                $this->_getTranslator()->translate('validation_message-auction_transaction_type_at_least_one_not_chosen')
            ),
            // second invalid
            array(
                Validate_Form_Container::MODE_AND,
                array(
                    ParamIdEnum::AUCTION_TRANSACTION_TYPE_BIDDING   =>  '1',
                    ParamIdEnum::AUCTION_TRANSACTION_TYPE_BUY_OUT   =>  '0',
                    FieldIdEnum::DELIVERY_TYPE_ID . '_1'            =>  '0',
                    FieldIdEnum::DELIVERY_TYPE_ID . '_2'            =>  '0'
                ),
                false,
                $this->_getTranslator()->translate('validation_message-delivery_at_least_one_not_chosen')
            ),
            // both valid
            array(
                Validate_Form_Container::MODE_AND,
                array(
                    ParamIdEnum::AUCTION_TRANSACTION_TYPE_BIDDING   =>  '0',
                    ParamIdEnum::AUCTION_TRANSACTION_TYPE_BUY_OUT   =>  '1',
                    FieldIdEnum::DELIVERY_TYPE_ID . '_1'            =>  '0',
                    FieldIdEnum::DELIVERY_TYPE_ID . '_2'            =>  '1'
                ),
                true,
                null
            ),
            
        //MODE OR
            // both invalid
            array(
                Validate_Form_Container::MODE_OR,
                array(
                    ParamIdEnum::AUCTION_TRANSACTION_TYPE_BIDDING   =>  '0',
                    ParamIdEnum::AUCTION_TRANSACTION_TYPE_BUY_OUT   =>  '0',
                    FieldIdEnum::DELIVERY_TYPE_ID . '_1'            =>  '0',
                    FieldIdEnum::DELIVERY_TYPE_ID . '_2'            =>  '0'
                ),
                false,
                $this->_getTranslator()->translate('validation_message-auction_transaction_type_at_least_one_not_chosen')
            ),
            // first invalid
            array(
                Validate_Form_Container::MODE_OR,
                array(
                    ParamIdEnum::AUCTION_TRANSACTION_TYPE_BIDDING   =>  '0',
                    ParamIdEnum::AUCTION_TRANSACTION_TYPE_BUY_OUT   =>  '0',
                    FieldIdEnum::DELIVERY_TYPE_ID . '_1'            =>  '1',
                    FieldIdEnum::DELIVERY_TYPE_ID . '_2'            =>  '0'
                ),
                false,
                $this->_getTranslator()->translate('validation_message-auction_transaction_type_at_least_one_not_chosen')
            ),
            // second invalid
            array(
                Validate_Form_Container::MODE_OR,
                array(
                    ParamIdEnum::AUCTION_TRANSACTION_TYPE_BIDDING   =>  '1',
                    ParamIdEnum::AUCTION_TRANSACTION_TYPE_BUY_OUT   =>  '0',
                    FieldIdEnum::DELIVERY_TYPE_ID . '_1'            =>  '0',
                    FieldIdEnum::DELIVERY_TYPE_ID . '_2'            =>  '0'
                ),
                false,
                $this->_getTranslator()->translate('validation_message-delivery_at_least_one_not_chosen')
            ),
            // both valid
            array(
                Validate_Form_Container::MODE_OR,
                array(
                    ParamIdEnum::AUCTION_TRANSACTION_TYPE_BIDDING   =>  '0',
                    ParamIdEnum::AUCTION_TRANSACTION_TYPE_BUY_OUT   =>  '1',
                    FieldIdEnum::DELIVERY_TYPE_ID . '_1'            =>  '0',
                    FieldIdEnum::DELIVERY_TYPE_ID . '_2'            =>  '1'
                ),
                true,
                null
            ),
        );
    }
    
    private function _getFilledForm(array $values)
    {
        $form = new Zend_Form();
        
        $form->addElement(new Form_Element_Select(ParamIdEnum::AUCTION_TRANSACTION_TYPE_BIDDING));
        $form->addElement(new Form_Element_Select(ParamIdEnum::AUCTION_TRANSACTION_TYPE_BUY_OUT));
        $form->addElement(new Form_Element_Select(FieldIdEnum::DELIVERY_TYPE_ID . '_1'));
        $form->addElement(new Form_Element_Select(FieldIdEnum::DELIVERY_TYPE_ID . '_2'));
        
        $form->isValid($values);
        
        return $form;
    }
}
