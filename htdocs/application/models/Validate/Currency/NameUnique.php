<?php
/**
 * @class Validate_Currency_NameUnique
 */
class Validate_Currency_NameUnique extends Zend_Validate_Abstract
{
    const NAME_EXISTS = 'nameExists';

    protected $_messageTemplates = array(
        self::NAME_EXISTS      =>  'validation_message-currency_name_exists',
    );
    
    public function isValid($value, $context = null)
    {
        $currencyId = array_key_exists(FieldIdEnum::CURRENCY_ID, $context) ? $context[FieldIdEnum::CURRENCY_ID] : null;
        
        if (!CurrencyTable::getInstance()->isCurrencyUnique($value, $currencyId))
        {
            $this->_error(self::NAME_EXISTS);
            return false;
        }
        
        return true;
    }
}
