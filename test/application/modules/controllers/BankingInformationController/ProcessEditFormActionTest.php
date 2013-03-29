<?php
/**
 * @class Auctions_BankingInformationController_ProcessEditFormActionTest
 */
class Auctions_BankingInformationController_ProcessEditFormActionTest extends TestCase_Controller
{
    
    /**
     * @test
     */
    public function process()
    {
        Fixture_Loader::create("Currency/1");
        Fixture_Loader::create("BankingInformation/1_currency_1_user_1");
        
        $request = array(
            FieldIdEnum::BANKING_INFORMATION_ID             =>  '1',
            FieldIdEnum::BANKING_INFORMATION_ACCOUNT_NUMBER =>  '1234',
            FieldIdEnum::BANKING_INFORMATION_BANK_NAME      =>  'super bank',
            FieldIdEnum::BANKING_INFORMATION_CURRENCY_ID    =>  '1'
        );
        
        $this->_setRequest($request);
        
        $this->dispatch("banking-information/process-edit-form");
        $this->_assertDispatch('banking-information', 'process-edit-form');
        
        $this->_assertRedirection("banking-information/show-list");
        
        $bankingInformations = BankingInformationTable::getInstance()->findAll();
        $this->assertEquals(1, count($bankingInformations));
        
        $bankingInformation = $bankingInformations->get(0);
        $this->assertEquals($request[FieldIdEnum::BANKING_INFORMATION_ID], $bankingInformation->id);
        $this->assertEquals($request[FieldIdEnum::BANKING_INFORMATION_ACCOUNT_NUMBER], $bankingInformation->account_number);
        $this->assertEquals($request[FieldIdEnum::BANKING_INFORMATION_BANK_NAME], $bankingInformation->bank_name);
        $this->assertEquals($request[FieldIdEnum::BANKING_INFORMATION_CURRENCY_ID], $bankingInformation->currency_id);
    }
    
    /**
     * @test
     */
    public function processWithInvalidData()
    {
        Fixture_Loader::create("Currency/1");
        Fixture_Loader::create("BankingInformation/1_currency_1_user_1");
        
        $this->_setRequest(array(
            FieldIdEnum::BANKING_INFORMATION_ID => '1'
        ));
        
        $this->dispatch("banking-information/process-edit-form");
        $this->_assertDispatch('banking-information', 'process-edit-form');
        $this->assertContains(Helper::getTranslator()->translate("validation_message-field_empty"), $this->getResponse()->getBody());
        
        $this->assertEquals(1, BankingInformationTable::getInstance()->count());
    }
}
