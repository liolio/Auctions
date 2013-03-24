<?php
/**
 * @class Auctions_Form_Category_Abstract
 */
abstract class Auctions_Form_Category_Abstract extends Auctions_Form_Abstract
{
    
    public function init()
    {
        $name = new Form_Element_Text(FieldIdEnum::CATEGORY_NAME);
        $name->setRequired()
                ->setLabel($this->_getTranslator()->translate('label-category_name'))
                ->addValidator(new Validate_StringLength(array('min' => 1, 'max' => 100)), true)
                ->addValidator(new Zend_Validate_Alpha());
        
        $description = new Form_Element_Textarea(FieldIdEnum::CATEGORY_DESCRIPTION);
        $description->setRequired()
                ->setLabel($this->_getTranslator()->translate('label-category_description'))
                ->addValidator(new Validate_StringLength(array('min' => 1, 'max' => 255)), true)
                ->addValidator(new Zend_Validate_Alpha());
        
        $parentCategory = new Zend_Form_Element_Select(FieldIdEnum::CATEGORY_PARENT_CATEGORY_ID);
        $parentCategory->setRequired()
                ->setLabel($this->_getTranslator()->translate('label-category_parent_category_id'))
                ->setMultiOptions($this->_getMultiOptionsForParentCategory());
        
        $addButton = new Zend_Form_Element_Submit(ParamIdEnum::SUBMIT_BUTTON);
        $addButton->setIgnore(true)
                ->setLabel($this->_getTranslator()->translate('caption-add'));
        
        $this->addElements(array($name, $description, $parentCategory, $addButton));
        
        $this->setDecorators(array(
            'FormElements',
            array('HtmlTag', array('tag' => 'dl', 'class' => 'zend_form')),
            array('Description', array('placement' => 'prepend')),
            'Form'
        ));
    }
    
    abstract protected function _getMultiOptionsForParentCategory();
    
}