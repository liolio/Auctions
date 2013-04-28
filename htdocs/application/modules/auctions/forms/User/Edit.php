<?php
/**
 * @class Auctions_Form_User_Edit
 */
class Auctions_Form_User_Edit extends Auctions_Form_Abstract
{

    public function __construct($options = array())
    {
        $formOptions = array_merge(
            array(
                'action' => '/user/process-edit-form',
                'method' => 'post',
            ), $options
        );
        
        parent::__construct($formOptions);
    }
    
    public function init()
    {
        $id = new Zend_Form_Element_Hidden(FieldIdEnum::USER_ID);
        $id->setRequired()
            ->addValidator(new Zend_Validate_Int());
        
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
        
        $active = new Zend_Form_Element_Checkbox(FieldIdEnum::USER_ACTIVE);
        $active->setRequired()
                ->setLabel($this->_getTranslator()->translate('label-user_active'));
        
        $role = new Form_Element_Select(FieldIdEnum::USER_ROLE);
        $role->setRequired()
                ->setLabel($this->_getTranslator()->translate('label-user_role'))
                ->setMultiOptions($this->_getMultiOptionsForParentCategory());
        
        $changeButton = new Zend_Form_Element_Submit(ParamIdEnum::FORM_EDIT_BUTTON);
        $changeButton->setIgnore(true); 
        
        $this->addElements(array($id, $login, $email, $active, $role, $changeButton));
    }
    
    private function _getMultiOptionsForParentCategory()
    {
        $roles = array();
        
        foreach (Enum_Db_User_Role::getEnums() as $role)
            $roles[$role] = $role;
        
        return $roles;
    }
}
