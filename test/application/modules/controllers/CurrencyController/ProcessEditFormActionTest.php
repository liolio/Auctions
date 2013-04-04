<?php
/**
 * @class Auctions_CurrencyController_ProcessEditFormActionTest
 */
class Auctions_CurrencyController_ProcessEditFormActionTest extends TestCase_Controller
{
    
    /**
     * @test
     */
    public function process()
    {
        $this->_loadFixture("Currency/1");
        $request = array(
            FieldIdEnum::CURRENCY_ID    =>  '1',
            FieldIdEnum::CURRENCY_NAME  =>  'EUR',
        );
        
        $this->_setRequest($request);
        
        $this->dispatch("currency/process-edit-form");
        $this->_assertDispatch('currency', 'process-edit-form');
        
        $this->_assertRedirection("currency/show-administrator-list");
        
        $currencies = CurrencyTable::getInstance()->findAll();
        $this->assertEquals(1, count($currencies));
        
        $currency = $currencies->get(0);
        $this->assertEquals($request[FieldIdEnum::CURRENCY_NAME], $currency->name);
    }
    
    /**
     * @test
     */
    public function processWithInvalidData()
    {
        $this->_setRequest(array());
        
        $this->dispatch("currency/process-edit-form");
        $this->_assertDispatch('currency', 'process-edit-form');
        $this->assertContains(Helper::getTranslator()->translate("validation_message-field_empty"), $this->getResponse()->getBody());
        
        $this->assertEquals(0, CurrencyTable::getInstance()->count());
    }
}
