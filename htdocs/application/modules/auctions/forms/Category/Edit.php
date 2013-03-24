<?php
/**
 * @class Auctions_Form_Category_Edit
 */
class Auctions_Form_Category_Edit extends Auctions_Form_Category_Abstract
{
    
    /**
     * @var String
     */
    private $_withoutCategoryId;
    
    public function __construct($options = array())
    {
        $formOptions = array_merge(
            array(
                'action' => '/category/process-edit-form',
                'method' => 'post',
            ), $options
        );
        
        $this->_withoutCategoryId = $options[ParamIdEnum::CATEGORY_WITHOUT_CATEGORY_ID];
        
        parent::__construct($formOptions);
    }
    
    public function init()
    {
        $id = new Zend_Form_Element_Hidden(FieldIdEnum::CATEGORY_ID);
        $id->setRequired()
            ->addValidator(new Zend_Validate_Int());
        $this->addElement($id);
        
        parent::init();
    }
    
    protected function _getMultiOptionsForParentCategory()
    {
        return CategoryTable::getInstance()->getCategoriesListToList($this->_withoutCategoryId);
    }

    protected function _getSubmitButtonLabelKey()
    {
        return 'caption-edit';
    }
}
