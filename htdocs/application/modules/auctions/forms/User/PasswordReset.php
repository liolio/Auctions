<?php
/**
 * @class Auctions_Form_User_PasswordReset
 */
class Auctions_Form_User_PasswordReset extends Auctions_Form_Abstract
{
    
    public function __construct($options = array())
    {
        $formOptions = array_merge(
            array(
                'action' => '/user/process-password-reset-form',
                'method' => 'post',
            ), $options
        );
        
        parent::__construct($formOptions);
    }
    
    public function init()
    {
        $email = new Form_Element_Text(FieldIdEnum::USER_EMAIL);
        $email->setRequired()
                ->setLabel($this->_getTranslator()->translate('label-email'))
                ->addValidator(new Validate_StringLength(array('min' => 1, 'max' => 100)), true)
                ->addValidator(new Zend_Validate_EmailAddress(), true)
                ->addValidator(new Validate_User_EmailExists());
        
        
        $sendRequestButton = new Zend_Form_Element_Submit(ParamIdEnum::SUBMIT_BUTTON);
        $sendRequestButton->setIgnore(true)
                ->setLabel($this->_getTranslator()->translate('button-send'));
        
        $this->addElements(array($email, $sendRequestButton));
        
        $this->setDecorators(array(
            'FormElements',
            array('HtmlTag', array('tag' => 'dl', 'class' => 'zend_form')),
            array('Description', array('placement' => 'prepend')),
            'Form'
        ));
    }
}
