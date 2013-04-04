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
        $this->_loadFixtures(array(
            'Currency/1',
            'User/2',
            'BankingInformation/1_currency_1_user_1',
            'BankingInformation/2_currency_1_user_2'
        ));
        
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
