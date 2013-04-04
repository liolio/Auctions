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
        $this->_loadFixture("Currency/1");
        $this->_loadFixture("BankingInformation/1_currency_1_user_1");
        
        $this->dispatch('/banking-information/delete/1');
        $this->_assertDispatch('banking-information', 'delete');
        
        $this->_assertRedirection("banking-information/show-list");
        
        $this->assertEquals(0, BankingInformationTable::getInstance()->count());
    }
}
