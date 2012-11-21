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
                'Zend_Validate_StringLength',
                'Zend_Validate_Alpha'
            ),
            FieldIdEnum::ADDRESS_SURNAME        =>  array(
                'Zend_Validate_StringLength',
                'Validate_Address_SurnameRegex'
            ),
            FieldIdEnum::ADDRESS_STREET         =>  array(
                'Zend_Validate_StringLength',
                'Validate_Address_StreetRegex'
            ),
            FieldIdEnum::ADDRESS_POSTAL_CODE    =>  array(
                'Zend_Validate_StringLength',
                'Validate_Address_PostalCodeRegex'
            ),
            FieldIdEnum::ADDRESS_CITY           =>  array(
                'Zend_Validate_StringLength',
                'Zend_Validate_Alpha'
            ),
            FieldIdEnum::ADDRESS_COUNTRY        =>  array(
                'Zend_Validate_StringLength',
                'Zend_Validate_Alpha'
            ),
            FieldIdEnum::ADDRESS_PROVINCE       =>  array(
                'Zend_Validate_StringLength',
                'Zend_Validate_Alpha'
            ),
            FieldIdEnum::ADDRESS_PHONE_NUMBER   =>  array(
                'Zend_Validate_StringLength',
                'Validate_Address_PhoneNumberRegex'
            ),
        );
        
        $this->assertEquals($expectedFields, $fields);
    }
}
