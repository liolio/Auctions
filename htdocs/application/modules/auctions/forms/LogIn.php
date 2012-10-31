<?php
/**
 * @class Auctions_Form_LogIn
 */
class Auctions_Form_LogIn extends Auctions_Form_Abstract
{
    
    public function __construct($options = array())
    {
        $formOptions = array_merge($options,
            array(
                'action' => '/login/process',
                'method' => 'post',
            )
        );
        
        parent::__construct($formOptions);
    }
    
    public function init()
    {
        $userLogin = new Form_Element_Text(FieldIdEnum::USER_LOGIN);
        $userLogin->setRequired()
                ->setLabel($this->_getTranslator()->translate('label-login'))
                ->addValidator(new Zend_Validate_Alnum(), true)
                ->addValidator(new Zend_Validate_StringLength(array('min' => 1, 'max' => 20)));

        $userPassword = new Zend_Form_Element_Password(FieldIdEnum::USER_PASSWORD);
        $userPassword->setRequired()
                ->setLabel($this->_getTranslator()->translate('label-password'))
                ->addFilter(new Zend_Filter_StringTrim())
                ->addFilter(new Zend_Filter_StripTags())
                ->addValidator(new Zend_Validate_StringLength(array('min' => 1, 'max' => 20)));
        
        $loginButton = new Zend_Form_Element_Submit(ParamIdEnum::SUBMIT_BUTTON);
        $loginButton->setIgnore(true)
                ->setLabel($this->_getTranslator()->translate('button-log_in'));
        
        $this->addElements(array($userLogin, $userPassword, $loginButton));
        
        // We want to display a 'failed authentication' message if necessary;
        // we'll do that with the form 'description', so we need to add that
        // decorator.
        $this->setDecorators(array(
            'FormElements',
            array('HtmlTag', array('tag' => 'dl', 'class' => 'zend_form')),
            array('Description', array('placement' => 'prepend')),
            'Form'
        ));
    }
}