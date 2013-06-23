<?php
/**
 * @class Auctions_Form_News_Abstract
 */
abstract class Auctions_Form_News_Abstract extends Auctions_Form_Abstract
{
    
    public function init()
    {
        $title = new Form_Element_Text(FieldIdEnum::NEWS_TITLE);
        $title->setRequired()
                ->setLabel($this->_getTranslator()->translate('label-news_title'))
                ->addValidator(new Validate_StringLength(array('min' => 1, 'max' => 100)));
        
        $editor = new Form_Element_Textarea(FieldIdEnum::NEWS_DESCRIPTION, false);
        $editor->setRequired()
                ->setLabel($this->_getTranslator()->translate('label-auction_description'));
        
        $this->addElements(array($title, $editor, $this->_getSubmitButton()));
        
        $this->setDecorators(array(
            'FormElements',
            array('HtmlTag', array('tag' => 'dl', 'class' => 'zend_form')),
            array('Description', array('placement' => 'prepend')),
            'Form'
        ));
    }
    
    abstract protected function _getSubmitButton();
    
}
