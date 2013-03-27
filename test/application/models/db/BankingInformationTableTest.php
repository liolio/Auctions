<?php
/**
 * @class BankingInformationTableTest
 */
class BankingInformationTableTest extends TestCase_Database
{
    
    /**
     * @test
     * @dataProvider bankingInformationUniqueDataProvider
     */
    public function isBankingInformationUnique($accountNumber, $bankName, $currencyId, $bankingInformationId, $expectedResult)
    {
        Fixture_Loader::create('Currency/1');
        Fixture_Loader::create('User/2');
        Fixture_Loader::create('BankingInformation/1_currency_1_user_1');
        Fixture_Loader::create('BankingInformation/2_currency_1_user_2');
        
        $user = UserTable::getInstance()->find(1);
        
        $this->assertEquals(
            $expectedResult,
            BankingInformationTable::getInstance()->isBankingInformationUnique($accountNumber, $bankName, $currencyId, $user, $bankingInformationId)
        );
    }
    
    public function bankingInformationUniqueDataProvider()
    {
        return array(
            array('123 432 6456 7657', 'polski bank 2', 1, null, true), //different account number
            array('123 432 6456 7657 1', 'polski bank', 1, null, true), //different bank name
            array('123 432 6456 7657', 'polski bank', 2, null, true),   //different currency id
            array('123 432 6456 7657', 'polski bank', 1, 1, true),      //identical in databse but ignore id 1
            array('987 654 3210 5555', 'polski bank', 1, null, true),   //identical in databse but configured for different user
            array('987 654 3210 5555', 'polski bank', 1, 1, true),      //identical in databse but configured for different user
            
            array('123 432 6456 7657', 'polski bank', 1, null, false)   //identical in databse
        );
    }
}
