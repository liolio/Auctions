<?php
/**
 * @class Auctions_Form_Currency_Abstract
 */
abstract class Auctions_Form_Currency_Abstract extends Auctions_Form_Abstract
{
    
    public function init()
    {
        $name = new Form_Element_Text(FieldIdEnum::CURRENCY_NAME);
        $name->setRequired()
                ->setLabel($this->_getTranslator()->translate('label-currency_name'))
                ->addValidator(new Validate_StringLength(array('min' => 1, 'max' => 100)), true)
                ->addValidator(new Validate_Currency_NameUnique());
        
        $this->addElements(array($name, $this->_getSubmitButton()));
        
        $this->setDecorators(array(
            'FormElements',
            array('HtmlTag', array('tag' => 'dl', 'class' => 'zend_form')),
            array('Description', array('placement' => 'prepend')),
            'Form'
        ));
    }
    
    abstract protected function _getSubmitButton();
    
}
