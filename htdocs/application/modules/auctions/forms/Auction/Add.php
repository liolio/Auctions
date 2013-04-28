<?php
/**
 * @class Auctions_Form_Auction_Add
 */
class Auctions_Form_Auction_Add extends Auctions_Form_Abstract
{
    
    /**
     * @var boolean
     */
    private static $_enableFileFields = true;
    
    public function __construct($options = array())
    {
        $formOptions = array_merge(
            array(
                'action' => '/auction/process-add-form',
                'method' => 'post',
                'id'     => 'fullPage'
            ), $options
        );
        
        parent::__construct($formOptions);
    }
    
    /**
     * For testing purpose only. Parameter decides whether add file related fields or not.
     * 
     * @param boolean $add
     */
    public static function addFileFields($add = true)
    {
        self::$_enableFileFields = $add;
    }
    
    public function init()
    {
        $this->_addBaseFields();
        $this->_addAuctionTransactionFields();
        $this->_addDeliveryFields();
        
        if (self::$_enableFileFields)
            $this->_addFileFields();
        
        $addButton = new Zend_Form_Element_Submit(ParamIdEnum::FORM_ADD_BUTTON);
        $addButton->setIgnore(true);
        
        $this->addElement($addButton);
        
        $this->setDecorators(array(
            'FormElements',
            array('HtmlTag', array('tag' => 'dl', 'class' => 'zend_form')),
            array('Description', array('placement' => 'prepend')),
            'Form'
        ));
    }
    
    public function isValid($data)
    {
        $this->getElement(ParamIdEnum::AUCTION_TRANSACTION_TYPE_BIDDING_PRICE)->setRequired($data[ParamIdEnum::AUCTION_TRANSACTION_TYPE_BIDDING] != 0);
        $this->getElement(ParamIdEnum::AUCTION_TRANSACTION_TYPE_BUY_OUT_PRICE)->setRequired($data[ParamIdEnum::AUCTION_TRANSACTION_TYPE_BUY_OUT] != 0);
        
        foreach (DeliveryTypeTable::getInstance()->getIds() as $deliveryTypeId)
            $this->getElement(FieldIdEnum::DELIVERY_PRICE . "_" . $deliveryTypeId)
                ->setRequired($data[FieldIdEnum::DELIVERY_TYPE_ID . "_" . $deliveryTypeId] != 0);
        
        $auctionFileId = $this->getElement(FieldIdEnum::AUCTION_FILE_ID);
        if (!is_null($auctionFileId)) 
            $auctionFileId->setRequired($this->_isThumbnailChooseRequired());
        
        return parent::isValid($data);
    }
    
    private function _addBaseFields()
    {
        $category = new Form_Element_Select(FieldIdEnum::CATEGORY_ID);
        $category->setRequired()
                ->setLabel($this->_getTranslator()->translate('label-auction_category'))
                ->setMultiOptions(CategoryTable::getInstance()->getCategoriesListToList(null, false));
        
        $title = new Form_Element_Text(FieldIdEnum::AUCTION_TITLE);
        $title->setRequired()
                ->addValidator(new Validate_StringLength(array('min' => 1, 'max' => 100)))
                ->setLabel($this->_getTranslator()->translate('label-auction_title'));
                
        $editor = new Form_Element_Textarea(ParamIdEnum::CKEDITOR, false);
        $editor->setRequired()
                ->setLabel($this->_getTranslator()->translate('label-auction_description'));
        
        $startTime = new Form_Element_Text(FieldIdEnum::AUCTION_START_TIME);
        $startTime->setRequired()
                ->addValidator(new Validate_Date(array('format' => 'yyyy-mm-dd HH:mm:ss')))
                ->setLabel($this->_getTranslator()->translate('label-auction_start_time'));
        
        $duration = new Form_Element_Select(FieldIdEnum::AUCTION_DURATION);
        $duration->setRequired()
                ->setLabel($this->_getTranslator()->translate('label-auction_duration'))
                ->setMultiOptions(Auction_Duration::getDurationListToList());
        
        $numberOfItems = new Form_Element_Text(FieldIdEnum::AUCTION_NUMBER_OF_ITEMS);
        $numberOfItems->setRequired()
                ->addValidator(new Validate_Int())
                ->setLabel($this->_getTranslator()->translate('label-auction_number_of_items'));
        
        $currency = new Form_Element_Select(FieldIdEnum::CURRENCY_ID);
        $currency->setRequired()
                ->setLabel($this->_getTranslator()->translate('label-banking_information_currency'))
                ->setMultiOptions($this->_getMultiOptionsForCurrency());
        
        $this->addElements(array($category, $title, $editor, $startTime, $duration, $numberOfItems, $currency));
    }
    
    private function _addAuctionTransactionFields()
    {
        $bidding = new Zend_Form_Element_Checkbox(ParamIdEnum::AUCTION_TRANSACTION_TYPE_BIDDING);
        $bidding->setLabel($this->_getTranslator()->translate('label-auction_transaction_type_bidding'));
        
        $biddingPrice = new Form_Element_Text(ParamIdEnum::AUCTION_TRANSACTION_TYPE_BIDDING_PRICE);
        $biddingPrice->setRequired()
                ->setLabel($this->_getTranslator()->translate('label-auction_transaction_type_bidding_price'))
                ->addValidator(new Validate_StringLength(array('min' => 1, 'max' => 15)), true)
                ->addValidator(new Validate_Float());
        
        $buyOut = new Zend_Form_Element_Checkbox(ParamIdEnum::AUCTION_TRANSACTION_TYPE_BUY_OUT);
        $buyOut->setLabel($this->_getTranslator()->translate('label-auction_transaction_type_buy_out'));
        
        $buyOutPrice = new Form_Element_Text(ParamIdEnum::AUCTION_TRANSACTION_TYPE_BUY_OUT_PRICE);
        $buyOutPrice->setRequired()
                ->setLabel($this->_getTranslator()->translate('label-auction_transaction_type_buy_out_price'))
                ->addValidator(new Validate_StringLength(array('min' => 1, 'max' => 15)), true)
                ->addValidator(new Validate_Float());
        
        $this->addDisplayGroup(array($bidding, $biddingPrice, $buyOut, $buyOutPrice), ParamIdEnum::FIELDSET_AUCTION_TRANSACTION_TYPE, array(
            'legend'    =>  $this->getTranslator()->translate('fieldset_legend-auction_transaction_types')
        ));
    }
    
    private function _addDeliveryFields()
    {
        $deliveryElements = new Form_Elements_Delivery();
        
        $this->addDisplayGroup($deliveryElements->getCashByTransferElements(), ParamIdEnum::FIELDSET_DELIVERY_CASH_BY_TRANSFER, array(
            'legend'    =>  $this->getTranslator()->translate('fieldset_legend-cash_by_transfer')
        ));
        
        $this->addDisplayGroup($deliveryElements->getCashOnDeliveryElements(), ParamIdEnum::FIELDSET_DELIVERY_CASH_ON_DELIVERY, array(
            'legend'    =>  $this->getTranslator()->translate('fieldset_legend-cash_on_delivery')
        ));
    }
    
    private function _addFileFields()
    {
        $attachmentsElements = new Form_Elements_Attachments();
        
        $this->addDisplayGroup($attachmentsElements->getElements(), ParamIdEnum::FIELDSET_FILES, array(
            'legend'    =>  $this->getTranslator()->translate("caption-photos")
        ));
    }
    
    private function _isThumbnailChooseRequired()
    {
        for ($i = 1; $i < 6; $i++)
        {
            $fileName = $this->getElement(ParamIdEnum::FILE . "_" . $i)->getFileName();
            
            if (!(is_array($fileName) && count($fileName) === 0 ))
                return true;
        }
        return false;
    }
    
    private function _getMultiOptionsForCurrency()
    {
        $currenciesArray = array();
        
        foreach (CurrencyTable::getInstance()->findAll() as $currency)
            $currenciesArray[$currency->id] = $currency->name;
        
        return $currenciesArray;
    }
    
}
