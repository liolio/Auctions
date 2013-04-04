<?php
/**
 * @class Auctions_CurrencyController_ProcessAddFormActionTest
 */
class Auctions_CurrencyController_ProcessAddFormActionTest extends TestCase_Controller
{
    
    /**
     * @test
     */
    public function process()
    {
        $this->_loadFixture("Currency/1");
        
        $request = array(
            FieldIdEnum::CURRENCY_NAME  =>  'EUR',
        );
        
        $this->_setRequest($request);
        
        $this->dispatch("currency/process-add-form");
        $this->_assertDispatch('currency', 'process-add-form');
        
        $this->_assertRedirection("currency/show-administrator-list");
        
        $currencies = CurrencyTable::getInstance()->findAll();
        $this->assertEquals(2, count($currencies));
        
        $currency = $currencies->get(1);
        $this->assertEquals($request[FieldIdEnum::CURRENCY_NAME], $currency->name);
    }
    
    /**
     * @test
     */
    public function processWithInvalidData()
    {
        $this->_setRequest(array());
        
        $this->dispatch("currency/process-add-form");
        $this->_assertDispatch('currency', 'process-add-form');
        $this->assertContains(Helper::getTranslator()->translate("validation_message-field_empty"), $this->getResponse()->getBody());
        
        $this->assertEquals(0, CurrencyTable::getInstance()->count());
    }
}
