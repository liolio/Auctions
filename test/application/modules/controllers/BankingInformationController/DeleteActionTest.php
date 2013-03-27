<?php
/**
 * @class Auctions_BankingInformationController_DeleteActionTest
 */
class Auctions_BankingInformationController_DeleteActionTest extends TestCase_Controller
{
    
    /**
     * @test
     */
    public function delete()
    {
        Fixture_Loader::create("Currency/1");
        Fixture_Loader::create("BankingInformation/1_currency_1_user_1");
        
        $this->dispatch('/banking-information/delete/1');
        $this->_assertDispatch('banking-information', 'delete');
        
        $this->_assertRedirection("banking-information/show-list");
        
        $this->assertEquals(0, BankingInformationTable::getInstance()->count());
    }
}
