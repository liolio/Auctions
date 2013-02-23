<?php
/**
 * @class Form_Elements_Address
 */
class Form_Elements_Address extends Form_Elements
{
    
    public function getElements()
    {
        $name = new Form_Element_Text(FieldIdEnum::ADDRESS_NAME);
        $name->setRequired()
                ->setLabel($this->_getTranslator()->translate('label-address_name'))
                ->addValidator(new Validate_StringLength(array('min' => 1, 'max' => 100)), true)
                ->addValidator(new Zend_Validate_Alpha(true));

        $surname = new Form_Element_Text(FieldIdEnum::ADDRESS_SURNAME);
        $surname->setRequired()
                ->setLabel($this->_getTranslator()->translate('label-address_surname'))
                ->addValidator(new Validate_StringLength(array('min' => 1, 'max' => 100)), true)
                ->addValidator(new Validate_Address_SurnameRegex());

        $street = new Form_Element_Text(FieldIdEnum::ADDRESS_STREET);
        $street->setRequired()
                ->setLabel($this->_getTranslator()->translate('label-address_street'))
                ->addValidator(new Validate_StringLength(array('min' => 1, 'max' => 100)), true)
                ->addValidator(new Validate_Address_StreetRegex());

        $postalCode = new Form_Element_Text(FieldIdEnum::ADDRESS_POSTAL_CODE);
        $postalCode->setRequired()
                ->setLabel($this->_getTranslator()->translate('label-address_postal_code'))
                ->addValidator(new Validate_StringLength(array('min' => 1, 'max' => 100)), true)
                ->addValidator(new Validate_Address_PostalCodeRegex());

        $city = new Form_Element_Text(FieldIdEnum::ADDRESS_CITY);
        $city->setRequired()
                ->setLabel($this->_getTranslator()->translate('label-address_city'))
                ->addValidator(new Validate_StringLength(array('min' => 1, 'max' => 100)), true)
                ->addValidator(new Zend_Validate_Alpha(true));

        $province = new Form_Element_Text(FieldIdEnum::ADDRESS_PROVINCE);
        $province->setRequired()
                ->setLabel($this->_getTranslator()->translate('label-address_province'))
                ->addValidator(new Validate_StringLength(array('min' => 1, 'max' => 100)))
                ->addValidator(new Zend_Validate_Alpha(true));

        $country = new Form_Element_Text(FieldIdEnum::ADDRESS_COUNTRY);
        $country->setRequired()
                ->setLabel($this->_getTranslator()->translate('label-address_country'))
                ->addValidator(new Validate_StringLength(array('min' => 1, 'max' => 100)))
                ->addValidator(new Zend_Validate_Alpha(true));

        $phoneNumber = new Form_Element_Text(FieldIdEnum::ADDRESS_PHONE_NUMBER);
        $phoneNumber->setRequired()
                ->setLabel($this->_getTranslator()->translate('label-address_phone_number'))
                ->addValidator(new Validate_StringLength(array('min' => 1, 'max' => 100)), true)
                ->addValidator(new Validate_Address_PhoneNumberRegex());
        
        return array($name, $surname, $street, $postalCode, $city, $province, $country, $phoneNumber);
    }
}
