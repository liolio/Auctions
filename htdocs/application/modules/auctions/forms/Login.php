<?php
/**
 * @class Auctions_Form_Login
 */
class Auctions_Form_Login extends Zend_Form
{
    public function init()
    {
        $userLogin = new Form_Element_Text(FieldIdEnum::USER_LOGIN);
        $userLogin->setRequired()
                ->setLabel('Login:')
                ->addValidator(new Zend_Validate_Alpha(), true)
                ->addValidator(new Zend_Validate_StringLength(array(1, 20)));

        $userPassword = new Zend_Form_Element_Password(FieldIdEnum::USER_PASSWORD);
        $userPassword->setRequired()
                ->setLabel('Password:')
                ->addFilter(new Zend_Filter_StringTrim())
                ->addFilter(new Zend_Filter_StripTags())
                ->addValidator(new Zend_Validate_StringLength(array(1, 20)));
        
        $loginButton = new Zend_Form_Element_Submit('submitButton');
        $loginButton->setIgnore(true)
                ->setLabel('Login');
        
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