<?php
/**
 * @class Address_Factory
 */
class Address_Factory
{
    
    /**
     * Creates new Address object for given user.
     * 
     * @param User $user
     * @param array $data Array of valid data.
     * @return Address
     */
    public static function create(User $user, array $data)
    {
        $address = new Address();
        
        $address->name = $data[FieldIdEnum::ADDRESS_NAME];
        $address->surname = $data[FieldIdEnum::ADDRESS_SURNAME];
        $address->street = $data[FieldIdEnum::ADDRESS_STREET];
        $address->postal_code = $data[FieldIdEnum::ADDRESS_POSTAL_CODE];
        $address->city = $data[FieldIdEnum::ADDRESS_CITY];
        $address->country = $data[FieldIdEnum::ADDRESS_COUNTRY];
        $address->phone_number = $data[FieldIdEnum::ADDRESS_PHONE_NUMBER];
        $address->province = $data[FieldIdEnum::ADDRESS_PROVINCE];
        $address->User = $user;
        
        return $address;
    }
}
