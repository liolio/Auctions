<?php
/**
 * @class Auctions_Form_News_Add
 */
class Auctions_Form_News_Add extends Auctions_Form_News_Abstract
{
    
    public function __construct($options = array())
    {
        $formOptions = array_merge(
            array(
                'action' => '/news/process-add-form',
                'method' => 'post'
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
