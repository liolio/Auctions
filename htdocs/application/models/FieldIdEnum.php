<?php
/**
 * @class FieldIdEnum
 */
class FieldIdEnum extends Enum_Abstract
{
    
    const USER_ID = 'user_id';
    const USER_LOGIN = 'user_login';
    const USER_PASSWORD = 'user_password';
    const USER_EMAIL = 'user_email';
    const USER_SECRET_CODE = 'user_secret_code';
    const USER_ACTIVE = 'user_active';
    const USER_ROLE = 'user_role';
    
    const ADDRESS_ID = 'address_id';
    const ADDRESS_NAME = 'address_name';
    const ADDRESS_SURNAME = 'address_surname';
    const ADDRESS_STREET = 'address_street';
    const ADDRESS_POSTAL_CODE = 'address_postal_code';
    const ADDRESS_CITY = 'address_city';
    const ADDRESS_PROVINCE = 'address_province';
    const ADDRESS_COUNTRY = 'address_country';
    const ADDRESS_PHONE_NUMBER = 'address_phone_number';
    
    const CATEGORY_ID = 'category_id';
    const CATEGORY_NAME = 'category_name';
    const CATEGORY_DESCRIPTION = 'category_description';
    const CATEGORY_PARENT_CATEGORY_ID = 'category_parent_category_id';
    
    const CURRENCY_ID = 'currency_id';
    const CURRENCY_NAME = 'currency_name';
    
    const BANKING_INFORMATION_ID = 'banking_information_id';
    const BANKING_INFORMATION_BANK_NAME = 'banking_information_bank_name';
    const BANKING_INFORMATION_ACCOUNT_NUMBER = 'banking_information_account_number';
    const BANKING_INFORMATION_CURRENCY_ID = 'banking_information_currency_id';
    
}

