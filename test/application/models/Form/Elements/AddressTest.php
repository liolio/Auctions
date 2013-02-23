<?php

/**
 * @class Form_Elements_AddressTest
 */
class Form_Elements_AddressTest extends TestCase_NoDatabase
{
    
    /**
     * @test
     */
    public function getElements()
    {
        $formElements = new Form_Elements_Address();
        $fields = array();
        
        foreach ($formElements->getElements() as $element)
            $fields[$element->getName()] = array_keys($element->getValidators());
        
        $expectedFields = array(
            FieldIdEnum::ADDRESS_NAME           =>  array(
                'Validate_NotEmpty',
                'Validate_StringLength',
                'Zend_Validate_Alpha'
            ),
            FieldIdEnum::ADDRESS_SURNAME        =>  array(
                'Validate_NotEmpty',
                'Validate_StringLength',
                'Validate_Address_SurnameRegex'
            ),
            FieldIdEnum::ADDRESS_STREET         =>  array(
                'Validate_NotEmpty',
                'Validate_StringLength',
                'Validate_Address_StreetRegex'
            ),
            FieldIdEnum::ADDRESS_POSTAL_CODE    =>  array(
                'Validate_NotEmpty',
                'Validate_StringLength',
                'Validate_Address_PostalCodeRegex'
            ),
            FieldIdEnum::ADDRESS_CITY           =>  array(
                'Validate_NotEmpty',
                'Validate_StringLength',
                'Zend_Validate_Alpha'
            ),
            FieldIdEnum::ADDRESS_COUNTRY        =>  array(
                'Validate_NotEmpty',
                'Validate_StringLength',
                'Zend_Validate_Alpha'
            ),
            FieldIdEnum::ADDRESS_PROVINCE       =>  array(
                'Validate_NotEmpty',
                'Validate_StringLength',
                'Zend_Validate_Alpha'
            ),
            FieldIdEnum::ADDRESS_PHONE_NUMBER   =>  array(
                'Validate_NotEmpty',
                'Validate_StringLength',
                'Validate_Address_PhoneNumberRegex'
            ),
        );
        
        $this->assertEquals($expectedFields, $fields);
    }
}
