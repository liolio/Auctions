<?php
return array(
    'application_name'  =>  'Aukcyjki',

    'caption-log_in'        =>  'Zaloguj',
    'caption-log_out'       =>  'Wyloguj',
    'caption-registration'  =>  'Rejestracja',
    
    'label-login'           =>  'Login:',
    'label-password'        =>  'Hasło:',
    'label-password_repeat' =>  'Powtórz hasło:',
    'label-email'           =>  'Adres e-mail:',
    
    'button-log_in'             =>  'Zaloguj',
    'button-register'           =>  'Rejestruj',
    'button-change_password'    =>  'Ustaw hasło',
    
    'validation_message-invalid_credentials'        =>  'Podano zły login lub hasło',
    'validation_message-user_inactive'              =>  'Konto nieaktywne',
    'validation_message-user_login_exists'          =>  'Podany login jest już zajęty',
    'validation_message-user_email_exists'          =>  'Podany adres e-mail jest już zajęty',
    'validation_message-user_passwords_not_match'   =>  'Hasła niezgodne',
    
    'configuration-undefined'    =>  'undefined',
    
    'notification_subject-user_registration'    =>  'Rejestracja użytkownika w serwisie Aukcyjki',
    
    'notification_message-user_registration'    =>  'Witaj %%' . FieldIdEnum::USER_LOGIN . '%%<BR>' .
                                                    '<BR>'.
                                                    'Kliknij w ten link, aby aktywować konto: <a href="%%' . ParamIdEnum::LINK . '%%">%%' . ParamIdEnum::LINK . '%%</a>',
    
);