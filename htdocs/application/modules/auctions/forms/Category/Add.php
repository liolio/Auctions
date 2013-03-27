<?php
/**
 * @class Auctions_Form_Category_Add
 */
class Auctions_Form_Category_Add extends Auctions_Form_Category_Abstract
{
    
    public function __construct($options = array())
    {
        $formOptions = array_merge(
            array(
                'action' => '/category/process-add-form',
                'method' => 'post',
            ), $options
        );
        
        parent::__construct($formOptions);
    }
    
    protected function _getMultiOptionsForParentCategory()
    {
        return CategoryTable::getInstance()->getCategoriesListToList();
    }
    
    protected function _getSubmitButton()
    {
        $addButton = new Zend_Form_Element_Submit(ParamIdEnum::FORM_ADD_BUTTON);
        $addButton->setIgnore(true);
        
        return $addButton;
    }
    
}
