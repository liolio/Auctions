<?php
/**
 * @class BankingInformation_Factory
 */
class BankingInformation_Factory
{
    
    /**
     * Creates new BankingInformation object
     * 
     * @param array $data Array of valid data.
     * @return Address
     */
    public static function create(array $data, Currency $currency, User $user)
    {
        $bankingInformation = new BankingInformation();
        
        $bankingInformation->bank_name = $data[FieldIdEnum::BANKING_INFORMATION_BANK_NAME];
        $bankingInformation->account_number = $data[FieldIdEnum::BANKING_INFORMATION_ACCOUNT_NUMBER];
        $bankingInformation->Currency = $currency;
        $bankingInformation->User = $user;
        
        return $bankingInformation;
    }
}
