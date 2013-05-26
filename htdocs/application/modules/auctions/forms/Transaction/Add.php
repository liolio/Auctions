<?php
/**
 * @class Auctions_Form_Transaction_Add
 */
class Auctions_Form_Transaction_Add extends Auctions_Form_Abstract
{
    
    public function __construct($options = array())
    {
        $formOptions = array_merge(
            array(
                'action' => '/transaction/process-transaction-form',
                'method' => 'post',
                'class'  => 'auctionTransactionForm'
            ), $options
        );
        
        parent::__construct($formOptions);
    }
    
    public function init()
    {
        $transactionType = new Zend_Form_Element_Hidden(FieldIdEnum::TRANSACTION_TYPE_NAME);
        $transactionType->setRequired();
        
        $auctionId = new Zend_Form_Element_Hidden(FieldIdEnum::AUCTION_ID);
        $auctionId->setRequired()
                ->addValidator(new Validate_Int());
        
        $price = new Form_Element_Text(FieldIdEnum::TRANSACTION_PRICE);
        $price->setRequired()
            ->setLabel($this->_getTranslator()->translate('label-price'))
            ->addValidator(new Validate_StringLength(array('min' => 1, 'max' => 15)), true)
            ->addValidator(new Validate_Float(), true)
            ->addValidator(new Validate_Transaction_Price());
        
        $numberOfItems = new Form_Element_Text(FieldIdEnum::TRANSACTION_NUMBER_OF_ITEMS);
        $numberOfItems->setRequired()
            ->setLabel($this->_getTranslator()->translate('label-auction_number_of_items'))
            ->setValue(1)
            ->addValidator(new Validate_StringLength(array('min' => 1, 'max' => 15)), true)
            ->addValidator(new Validate_Int(), true)
            ->addValidator(new Validate_Transaction_NumberOfItems());
        
        
        $addButton = new Zend_Form_Element_Submit(ParamIdEnum::FORM_NEXT_BUTTON);
        $addButton->setIgnore(true);
        
        $this->addElements(array($transactionType, $auctionId, $price, $numberOfItems, $addButton));
    }
    
}
