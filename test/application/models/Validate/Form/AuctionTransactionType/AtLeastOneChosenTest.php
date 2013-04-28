<?php
/**
 * @class Validate_Form_AuctionTransactionType_AtLeastOneChosenTest
 */
class Validate_Form_AuctionTransactionType_AtLeastOneChosenTest extends TestCase_NoDatabase
{
    
    /**
     * @var Validate_Form_AuctionTransactionType_AtLeastOneChosen
     */
    private $_validator;
    
    protected function setUp()
    {
        parent::setUp();
        $this->_validator = new Validate_Form_AuctionTransactionType_AtLeastOneChosen();
    }
    
    /**
     * @test
     * @dataProvider isValidDataProvider
     */
    public function isValid(array $formValues, $expectedValue)
    {
        $this->assertEquals($expectedValue, $this->_validator->isValid($this->_getFilledForm($formValues)));
        
        $this->assertEquals(
            $expectedValue ?
                null :
                $this->_getTranslator()->translate('validation_message-auction_transaction_type_at_least_one_not_chosen'),
            $this->_validator->getMessage()    
        );
    }
    
    public function isValidDataProvider()
    {
        return array(
            array(
                array(
                    ParamIdEnum::AUCTION_TRANSACTION_TYPE_BIDDING   =>  '0',
                    ParamIdEnum::AUCTION_TRANSACTION_TYPE_BUY_OUT   =>  '0'
                ),
                false
            ),
            array(
                array(
                    ParamIdEnum::AUCTION_TRANSACTION_TYPE_BIDDING   =>  '1',
                    ParamIdEnum::AUCTION_TRANSACTION_TYPE_BUY_OUT   =>  '0'
                ),
                true
            ),
            array(
                array(
                    ParamIdEnum::AUCTION_TRANSACTION_TYPE_BIDDING   =>  '0',
                    ParamIdEnum::AUCTION_TRANSACTION_TYPE_BUY_OUT   =>  '1'
                ),
                true
            ),
            array(
                array(
                    ParamIdEnum::AUCTION_TRANSACTION_TYPE_BIDDING   =>  '1',
                    ParamIdEnum::AUCTION_TRANSACTION_TYPE_BUY_OUT   =>  '1'
                ),
                true
            ),
        );
    }
    
    private function _getFilledForm(array $values)
    {
        $form = new Zend_Form();
        
        $form->addElement(new Form_Element_Select(ParamIdEnum::AUCTION_TRANSACTION_TYPE_BIDDING));
        $form->addElement(new Form_Element_Select(ParamIdEnum::AUCTION_TRANSACTION_TYPE_BUY_OUT));
        
        $form->isValid($values);
        
        return $form;
    }
}
