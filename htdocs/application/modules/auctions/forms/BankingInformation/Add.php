<?php
/**
 * @class Auctions_Form_BankingInformation_Add
 */
class Auctions_Form_BankingInformation_Add extends Auctions_Form_BankingInformation_Abstract
{
    
    public function __construct($options = array())
    {
        $formOptions = array_merge(
            array(
                'action' => '/banking-information/process-add-form',
                'method' => 'post',
            ), $options
        );
        
        parent::__construct($formOptions);
    }
    
    protected function _getSubmitButton()
    {
        $addButton = new Zend_Form_Element_Submit(ParamIdEnum::FORM_ADD_BUTTON);
        $addButton->setIgnore(true);
        
        return $addButton;
    }
    
}
