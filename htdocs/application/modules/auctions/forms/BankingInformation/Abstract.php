<?php
/**
 * @class Auctions_Form_BankingInformation_Abstract
 */
abstract class Auctions_Form_BankingInformation_Abstract extends Auctions_Form_Abstract
{
    
     public function init()
    {
        $bankName = new Form_Element_Text(FieldIdEnum::BANKING_INFORMATION_BANK_NAME);
        $bankName->setRequired()
                ->setLabel($this->_getTranslator()->translate('label-banking_information_bank_name'))
                ->addValidator(new Validate_StringLength(array('min' => 1, 'max' => 100)));
        
        $accountNumber = new Form_Element_Text(FieldIdEnum::BANKING_INFORMATION_ACCOUNT_NUMBER);
        $accountNumber->setRequired()
                ->setLabel($this->_getTranslator()->translate('label-banking_information_account_number'))
                ->addValidator(new Validate_StringLength(array('min' => 1, 'max' => 100)), true)
                ->addValidator(new Validate_BankingInformation_AccountNumberUnique());
        
        $currency = new Zend_Form_Element_Select(FieldIdEnum::BANKING_INFORMATION_CURRENCY_ID);
        $currency->setRequired()
                ->setLabel($this->_getTranslator()->translate('label-banking_information_currency'))
                ->setMultiOptions($this->_getMultiOptionsForParentCategory());
        
        $this->addElements(array($bankName, $accountNumber, $currency, $this->_getSubmitButton()));
        
        $this->setDecorators(array(
            'FormElements',
            array('HtmlTag', array('tag' => 'dl', 'class' => 'zend_form')),
            array('Description', array('placement' => 'prepend')),
            'Form'
        ));
    }
    
    abstract protected function _getSubmitButton();
    
    private function _getMultiOptionsForParentCategory()
    {
        $currenciesArray = array();
        
        foreach (CurrencyTable::getInstance()->findAll() as $currency)
            $currenciesArray[$currency->id] = $currency->name;
        
        return $currenciesArray;
    }
}
