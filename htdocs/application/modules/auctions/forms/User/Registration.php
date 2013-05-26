<?php
/**
 * @class Auctions_Form_User_Registration
 */
class Auctions_Form_User_Registration extends Auctions_Form_Abstract
{
    
    /**
     * @var boolean
     */
    public static $_enableReCaptcha = true;
    
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
                ->addValidator(new Validate_StringLength(array('min' => 1, 'max' => 40)), true)
                ->addValidator(new Zend_Validate_Alnum(), true)
                ->addValidator(new Validate_User_LoginUnique());
        
        $email = new Form_Element_Text(FieldIdEnum::USER_EMAIL);
        $email->setRequired()
                ->setLabel($this->_getTranslator()->translate('label-email'))
                ->addValidator(new Validate_StringLength(array('min' => 1, 'max' => 100)), true)
                ->addValidator(new Zend_Validate_EmailAddress(), true)
                ->addValidator(new Validate_User_EmailUnique());
        
        $this->addElements(array($login, $email));
        
        $addressFormElements = new Form_Elements_Address();
        $this->addElements($addressFormElements->getElements());
        
        if (self::$_enableReCaptcha)
        {
            $reCaptchaConfig = Zend_Controller_Front::getInstance()->getParam('reCaptcha');

            $captcha = new Zend_Form_Element_Captcha(ParamIdEnum::RECAPTCHA,
                  array('captcha'        => 'ReCaptcha',
                        'captchaOptions' => array(
                            'captcha' => 'ReCaptcha', 
                            'service' => new Zend_Service_ReCaptcha(
                                    $reCaptchaConfig['key']['public'], 
                                    $reCaptchaConfig['key']['private']
                            )
                        )
                  )
            );
            
            $this->addElement($captcha);
        }
        
        $registerButton = new Zend_Form_Element_Submit(ParamIdEnum::FORM_NEXT_BUTTON);
        $registerButton->setIgnore(true);
        
        $this->addElement($registerButton);
        
        $this->setDecorators(array(
            'FormElements',
            array('HtmlTag', array('tag' => 'dl', 'class' => 'zend_form')),
            array('Description', array('placement' => 'prepend')),
            'Form'
        ));
    }
    
    /**
     * For testing purpose only. Parameter decides whether add captcha or not.
     * 
     * @param boolean $add
     */
    public static function addReCaptcha($add = true)
    {
        self::$_enableReCaptcha = $add;
    }
}
