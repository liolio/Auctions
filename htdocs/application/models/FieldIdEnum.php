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
    
    const AUCTION_ID = 'auction_id';
    const AUCTION_TITLE = 'auction_title';
    const AUCTION_DESCRIPTION = 'auction_description';
    const AUCTION_NUMBER_OF_ITEMS = 'auction_number_of_items';
    const AUCTION_DURATION = 'auction_duration';
    const AUCTION_START_TIME = 'auction_start_time';
    const AUCTION_FILE_ID = 'auction_file_id';
    
    const AUCTION_TRANSACTION_TYPE_PRICE = 'auction_transaction_type_price';
    
    const TRANSACTION_TYPE_NAME = 'transaction_type_name';
    
    const TRANSACTION_NUMBER_OF_ITEMS = 'transaction_number_of_items';
    const TRANSACTION_PRICE = 'transaction_price';
    
    const FILE_FILENAME = 'file_filename';
    const FILE_ORIGINAL_FILENAME = 'file_original_filename';
    const FILE_MIME_TYPE = 'file_mime_type';
    const FILE_SIZE = 'file_size';
    
    const DELIVERY_TYPE_ID = 'delivery_type_id';
    const DELIVERY_TYPE_NAME = 'delivery_type_name';
    const DELIVERY_TYPE_CASH_ON_DELIVERY = 'delivery_type_cash_on_delivery';
    
    const DELIVERY_PRICE = 'delivery_price';
    
}

