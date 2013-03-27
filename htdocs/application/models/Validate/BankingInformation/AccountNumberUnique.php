<?php
/**
 * @class Validate_BankingInformation_AccountNumberUnique
 */
class Validate_BankingInformation_AccountNumberUnique extends Zend_Validate_Abstract
{
    const NOT_UNIQUE = 'notUnique';

    protected $_messageTemplates = array(
        self::NOT_UNIQUE    =>  'validation_message-banking_information_already_exists',
    );
    
    public function isValid($value, $context = null)
    {
        $bankingInformationId = array_key_exists(FieldIdEnum::BANKING_INFORMATION_ID, $context) ? $context[FieldIdEnum::BANKING_INFORMATION_ID] : null;
        
        if (!BankingInformationTable::getInstance()->isBankingInformationUnique(
            $value,
            $context[FieldIdEnum::BANKING_INFORMATION_BANK_NAME],
            $context[FieldIdEnum::BANKING_INFORMATION_CURRENCY_ID],
            Auth_User::getInstance()->getUser(),
            $bankingInformationId
        ))
        {
            $this->_error(self::NOT_UNIQUE);
            return false;
        }
        
        return true;
    }
}
