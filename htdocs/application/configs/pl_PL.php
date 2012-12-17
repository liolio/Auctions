<?php
return array(
    'application_name'  =>  'Aukcyjki',

    'caption-log_in'            =>  'Zaloguj',
    'caption-log_out'           =>  'Wyloguj',
    'caption-registration'      =>  'Rejestracja',
    'caption-password_reset'    =>  'Zapomniałeś hasła?',
    
    'label-login'                   =>  'Login:',
    'label-password'                =>  'Hasło:',
    'label-password_repeat'         =>  'Powtórz hasło:',
    'label-email'                   =>  'Adres e-mail:',
    'label-address_name'            =>  'Imię:',
    'label-address_surname'         =>  'Nazwisko:',
    'label-address_street'          =>  'Adres:',
    'label-address_postal_code'     =>  'Kod pocztowy:',
    'label-address_city'            =>  'Miasto:',
    'label-address_province'        =>  'Województwo:',
    'label-address_country'         =>  'Kraj:',
    'label-address_phone_number'    =>  'Numer telefonu:',
    
    'button-log_in'             =>  'Zaloguj',
    'button-register'           =>  'Rejestruj',
    'button-change_password'    =>  'Ustaw hasło',
    'button-send'               =>  'Wyślij',
    
    'validation_message-invalid_credentials'                        =>  'Podano zły login lub hasło',
    'validation_message-user_inactive'                              =>  'Konto nieaktywne',
    'validation_message-user_login_exists'                          =>  'Podany login jest już zajęty',
    'validation_message-user_email_exists'                          =>  'Podany adres e-mail jest już zajęty',
    'validation_message-user_email_not_exists'                      =>  'Podany adres e-mail nie istnieje w bazie',
    'validation_message-user_passwords_not_match'                   =>  'Hasła niezgodne',
    'validation_message-address_surname_regex_not_match'            =>  "'%value%' może zawierać tylko litery, spacje i pauzy",
    'validation_message-address_street_regex_not_match'             =>  "'%value%' może zawierać tylko litery, cyfry, ukośniki, kropki, spacje i pauzy",
    'validation_message-address_postal_code_regex_not_match'        =>  "'%value%' może zawierać tylko litery, cyfry, spacje i pauzy",
    'validation_message-address_phone_number_code_regex_not_match'  =>  "'%value%' może zawierać tylko cyfry, spacje, plusy i pauzy",
    
    'configuration-undefined'    =>  'undefined',
    
    'notification_subject-user_registration'    =>  'Rejestracja użytkownika w serwisie Aukcyjki',
    
    'notification_message-user_registration'    =>  'Witaj %%' . FieldIdEnum::USER_LOGIN . '%%<BR>' .
                                                    '<BR>'.
                                                    'Kliknij w ten link, aby aktywować konto: <a href="%%' . ParamIdEnum::LINK . '%%">%%' . ParamIdEnum::LINK . '%%</a>',
    
    'notification_subject-user_password_reset'  =>  'Resetowanie hasła w serwisie Aukcyjki',
    
    'notification_message-user_password_reset' =>  'Witaj %%' . FieldIdEnum::USER_LOGIN . '%%<BR>' .
                                                    '<BR>'.
                                                    'Kliknij w ten link, aby zresetować hasło: <a href="%%' . ParamIdEnum::LINK . '%%">%%' . ParamIdEnum::LINK . '%%</a>',
    
);