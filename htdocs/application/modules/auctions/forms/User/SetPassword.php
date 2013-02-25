<?php
/**
 * @class Auctions_Form_User_ChangePassword
 */
class Auctions_Form_User_SetPassword extends Auctions_Form_Abstract
{
    
    public function __construct($options = array())
    {
        $formOptions = array_merge(
            array(
                'action' => '/user/process-change-password-form',
                'method' => 'post',
            ), $options
        );
        
        parent::__construct($formOptions);
    }
    
    public function init()
    {
        $login = new Form_Element_Text(FieldIdEnum::USER_LOGIN);
        $login->setLabel($this->_getTranslator()->translate('label-login'))
                ->setRequired()
                ->setAttrib('readonly', true);
        
        $password = new Form_Element_Password(FieldIdEnum::USER_PASSWORD);
        $password->setRequired()
                ->setLabel($this->_getTranslator()->translate('label-password'))
                ->addFilter(new Zend_Filter_StringTrim())
                ->addFilter(new Zend_Filter_StripTags())
                ->addValidator(new Validate_StringLength(array('min' => 1, 'max' => 40)));
        
        $passwordRepeat = new Form_Element_Password(ParamIdEnum::PASSWORD_REPEAT);
        $passwordRepeat->setRequired()
                ->setLabel($this->_getTranslator()->translate('label-password_repeat'))
                ->addFilter(new Zend_Filter_StringTrim())
                ->addFilter(new Zend_Filter_StripTags())
                ->addValidator(new Validate_StringLength(array('min' => 1, 'max' => 40)), true)
                ->addValidator(new Validate_User_PasswordRepeatMatch());
        
        $changeButton = new Zend_Form_Element_Submit(ParamIdEnum::SUBMIT_BUTTON);
        $changeButton->setIgnore(true)
                ->setLabel($this->_getTranslator()->translate('button-change_password'));
        
        $this->addElements(array($login, $password, $passwordRepeat, $changeButton));
        
        $this->setDecorators(array(
            'FormElements',
            array('HtmlTag', array('tag' => 'dl', 'class' => 'zend_form')),
            array('Description', array('placement' => 'prepend')),
            'Form'
        ));
    }
}
