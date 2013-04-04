<?php
/**
 * @class Auctions_CurrencyController_DeleteActionTest
 */
class Auctions_CurrencyController_DeleteActionTest extends TestCase_Controller
{
    
    /**
     * @test
     */
    public function deleteWithBankingInformationConfigured()
    {
        $this->_loadFixture("Currency/1");
        $this->_loadFixture("BankingInformation/1_currency_1_user_1");
        
        $this->dispatch('/currency/delete/1');
        $this->_assertDispatch('currency', 'delete');
        
        $this->assertContains(
            Helper::getTranslator()->translate('validation_message-cannot_delete_currency_has_banking_informations'),
            $this->getResponse()->getBody()
        );
        
        $this->assertEquals(1, CurrencyTable::getInstance()->count());
    }
    
    /**
     * @test
     */
    public function delete()
    {
        $this->_loadFixture("Currency/1");
        
        $this->dispatch('/currency/delete/1');
        $this->_assertDispatch('currency', 'delete');
        
        $this->_assertRedirection("currency/show-administrator-list");
        
        $this->assertEquals(0, CurrencyTable::getInstance()->count());
    }
}
