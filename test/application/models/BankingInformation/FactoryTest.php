<?php
/**
 * @class BankingInformation_FactoryTest
 */
class BankingInformation_FactoryTest extends TestCase_Database
{
    /**
     * @test
     */
    public function create()
    {
        Fixture_Loader::create('Currency/1');
        
        $user = UserTable::getInstance()->find(1);
        $currency = CurrencyTable::getInstance()->find(1);
        
        $data = array(
            FieldIdEnum::BANKING_INFORMATION_BANK_NAME      =>  'b_name',
            FieldIdEnum::BANKING_INFORMATION_ACCOUNT_NUMBER =>  'a_number',
        );
        
        $bankingInformation = BankingInformation_Factory::create($data, $currency, $user);
        
        $this->assertEquals($data[FieldIdEnum::BANKING_INFORMATION_BANK_NAME], $bankingInformation->bank_name);
        $this->assertEquals($data[FieldIdEnum::BANKING_INFORMATION_ACCOUNT_NUMBER], $bankingInformation->account_number);
        $this->assertEquals("admin", $bankingInformation->User->login);
        $this->assertEquals("PLN", $bankingInformation->Currency->name);
    }
}
