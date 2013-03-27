<?php
/**
 * @class Auctions_BankingInformationController_ProcessAddFormActionTest
 */
class Auctions_BankingInformationController_ProcessAddFormActionTest extends TestCase_Controller
{
    
    /**
     * @test
     */
    public function process()
    {
        Fixture_Loader::create("Currency/1");
        
        $request = array(
            FieldIdEnum::BANKING_INFORMATION_ACCOUNT_NUMBER =>  '1234',
            FieldIdEnum::BANKING_INFORMATION_BANK_NAME      =>  'super bank',
            FieldIdEnum::BANKING_INFORMATION_CURRENCY_ID    =>  '1'
        );
        
        $this->_setRequest($request);
        
        $this->dispatch("banking-information/process-add-form");
        $this->_assertDispatch('banking-information', 'process-add-form');
        
        $this->_assertRedirection("banking-information/show-list");
        
        $bankingInformations = BankingInformationTable::getInstance()->findAll();
        $this->assertEquals(1, count($bankingInformations));
        
        $bankingInformation = $bankingInformations->get(0);
        $this->assertEquals($request[FieldIdEnum::BANKING_INFORMATION_ACCOUNT_NUMBER], $bankingInformation->account_number);
        $this->assertEquals($request[FieldIdEnum::BANKING_INFORMATION_BANK_NAME], $bankingInformation->bank_name);
        $this->assertEquals("PLN", $bankingInformation->Currency->name);
        $this->assertEquals("admin", $bankingInformation->User->login);
    }
    
    /**
     * @test
     */
    public function processWithInvalidData()
    {
        $this->_setRequest(array());
        
        $this->dispatch("banking-information/process-add-form");
        $this->_assertDispatch('banking-information', 'process-add-form');
        $this->assertContains(Helper::getTranslator()->translate("validation_message-field_empty"), $this->getResponse()->getBody());
        
        $this->assertEquals(0, BankingInformationTable::getInstance()->count());
    }
}
