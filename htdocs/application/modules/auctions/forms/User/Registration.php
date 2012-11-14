<?php
/**
 * @class Auctions_Form_User_Registration
 */
class Auctions_Form_User_Registration extends Auctions_Form_Abstract
{
    
    public function __construct($options = array())
    {
        $formOptions = array_merge($options,
            array(
                'action' => '/user/process-registration-form',
                'method' => 'post',
            )
        );
        
        parent::__construct($formOptions);
    }
    
    public function init()
    {
        $login = new Form_Element_Text(FieldIdEnum::USER_LOGIN);
        $login->setRequired()
                ->setLabel($this->_getTranslator()->translate('label-login'))
                ->addValidator(new Zend_Validate_StringLength(array('min' => 1, 'max' => 40)), true)
                ->addValidator(new Validate_User_LoginUnique());
        
        $email = new Form_Element_Text(FieldIdEnum::USER_EMAIL);
        $email->setRequired()
                ->setLabel($this->_getTranslator()->translate('label-email'))
                ->addValidator(new Zend_Validate_StringLength(array('min' => 1, 'max' => 100)), true)
                ->addValidator(new Zend_Validate_EmailAddress(), true)
                ->addValidator(new Validate_User_EmailUnique());
        
        $registerButton = new Zend_Form_Element_Submit(ParamIdEnum::SUBMIT_BUTTON);
        $registerButton->setIgnore(true)
                ->setLabel($this->_getTranslator()->translate('button-register'));
        
        $this->addElements(array($login, $email, $registerButton));
        
        $this->setDecorators(array(
            'FormElements',
            array('HtmlTag', array('tag' => 'dl', 'class' => 'zend_form')),
            array('Description', array('placement' => 'prepend')),
            'Form'
        ));
    }
}
