<?php
return array(
    'application_name'  =>  'Aukcyjki',

    'caption-log_in'                =>  'Zaloguj',
    'caption-log_out'               =>  'Wyloguj',
    'caption-registration'          =>  'Rejestracja',
    'caption-password_reset'        =>  'Zapomniałeś hasła?',
    'caption-add'                   =>  'Dodaj',
    'caption-edit'                  =>  'Edycja',
    'caption-delete'                =>  'Usunięcie',
    'caption-category_main'         =>  'Kategoria główna',
    'caption-category_list_prefix'  =>  '- ',
    
    'menu-spearator'            =>  ' | ',
    'menu-log_in'               =>  'Logowanie',
    'menu-registration'         =>  'Rejestracja',
    'menu-user_panel'           =>  'Panel użytkownika',
    'menu-administrator'        =>  'Panel administratora',
    'menu-log_out'              =>  'Wyloguj',
    
    'submenu-categories_list'       =>  'List kategorii',
    'submenu-user_change_password'  =>  'Zmień hasło',
    'submenu-address_list'          =>  'Lista adresów',
    
    'label-login'                       =>  'Login:',
    'label-old_password'                =>  'Stare hasło:',
    'label-password'                    =>  'Hasło:',
    'label-password_repeat'             =>  'Powtórz hasło:',
    'label-email'                       =>  'Adres e-mail:',
    'label-address_name'                =>  'Imię:',
    'label-address_surname'             =>  'Nazwisko:',
    'label-address_street'              =>  'Adres:',
    'label-address_postal_code'         =>  'Kod pocztowy:',
    'label-address_city'                =>  'Miasto:',
    'label-address_province'            =>  'Województwo:',
    'label-address_country'             =>  'Kraj:',
    'label-address_phone_number'        =>  'Numer telefonu:',
    'label-category_name'               =>  'Nazwa:',
    'label-category_description'        =>  'Opis:',
    'label-category_parent_category_id' =>  'Nadrzędna kategoria:',
    
    'button-log_in'             =>  'Zaloguj',
    'button-register'           =>  'Rejestruj',
    'button-change_password'    =>  'Ustaw hasło',
    'button-send'               =>  'Wyślij',
    
    'validation_message-field_empty'                                =>  'Pole obowiązkowe, nie może zostać puste',
    'validation_message-invalid_type'                               =>  'Podano zły typ. Oczekiwano: %%types%%.',
    'validation_message-too_short'                                  =>  "'%value%' jest krótszy niż %min% znaków",
    'validation_message-too_long'                                   =>  "'%value%' jest dłuższy niż %max% znaków",
    'validation_message-invalid_credentials'                        =>  'Podano zły login lub hasło',
    'validation_message-user_inactive'                              =>  'Konto nieaktywne',
    'validation_message-user_login_exists'                          =>  'Podany login jest już zajęty',
    'validation_message-user_email_exists'                          =>  'Podany adres e-mail jest już zajęty',
    'validation_message-user_email_not_exists'                      =>  'Podany adres e-mail nie istnieje w bazie',
    'validation_message-user_password_not_match'                    =>  'Hasło niepoprawne',
    'validation_message-user_passwords_not_match'                   =>  'Hasła niezgodne',
    'validation_message-address_cannot_remove_last_address'         =>  "Nie można usunąć ostaniego adresu",
    'validation_message-address_surname_regex_not_match'            =>  "'%value%' może zawierać tylko litery, spacje i pauzy",
    'validation_message-address_street_regex_not_match'             =>  "'%value%' może zawierać tylko litery, cyfry, ukośniki, kropki, spacje i pauzy",
    'validation_message-address_postal_code_regex_not_match'        =>  "'%value%' może zawierać tylko litery, cyfry, spacje i pauzy",
    'validation_message-address_phone_number_code_regex_not_match'  =>  "'%value%' może zawierać tylko cyfry, spacje, plusy i pauzy",
    'validation_message-cannot_delete_category_has_subcategories'   =>  "Nie można usunąć kategorii, która posiada podkategorie",
    
    'configuration-undefined'    =>  'undefined',
    
    'notification-header'   =>  '<!DOCTYPE html>
                                    <html>
                                        <head>
                                            <title>aukcyjki</title>
                                            <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
                                        </head>
                                        <body>
                                            <div style="background:#f9f900;width:100%;text-align: center;padding:10px">
                                                <img src="http://pluton.kt.agh.edu.pl/~dlew/auctions/logo.png" alt="aukcyjki"/>
                                            </div>
                                            <div style="background: #ffffcc;padding:20px;font:0.8em tahoma">',
    'notification-footer'   =>             '</div>
                                            <div style="background: #ffffcc;padding:20px;font:0.6em tahoma">
                                                Nie odpowiadaj na tą wiadomosć. Została ona wysłana automatycznie przez portal aukcyjki.<br/>
                                                Jeżeli masz jakieś pytania skontaktuj się z nami: <a style="color:black;text-decoration:none;" href="mailto:pomoc@aukcyjki.pl">pomoc@aukcyjki.pl</a><br/>
                                            </div>
                                            <div style="background:#f9f900;width:100%;text-align: center;width:100%;margin:0;padding:10px 0;">&nbsp;
                                                <div style="margin:0;padding:0;padding-left:20px;text-align:left;float:left;font:0.8em tahoma">
                                                    aukcyjki
                                                </div>
                                                <div style="margin:0;padding-right:20px;text-align:right;float:right;font:0.8em tahoma">
                                                    2013
                                                </div>
                                            </div>
                                    </body>
                                    </html>',
    
    'notification_subject-user_registration'        =>  'Rejestracja użytkownika w serwisie Aukcyjki',
    
    'notification_message-user_registration'        =>  'Witaj %%' . ParamIdEnum::USER_FULLNAME . '%%,<br/>' .
                                                        '<br/>' .
                                                        'Na serwisie aukcyjki zostało stworzone nowe konto dla Ciebie:<br/>' .
                                                        '<br/>' .
                                                        '&nbsp;&nbsp;&nbsp;&nbsp;Nazwa użytkownika: %%' . FieldIdEnum::USER_LOGIN . '%%<br/>' .
                                                        '<br/>' .
                                                        'Kliknij w poniższy link aby ustawić hasło i aktywować konto:<br/>' .
                                                        '<br/>' .
                                                        '<a href="%%' . ParamIdEnum::LINK . '%%">%%' . ParamIdEnum::LINK . '%%</a><br/>' .
                                                        '<br/>' .
                                                        'Po aktywacji zostaniesz automatycznie zalogowany do portalu aukcyjki.',
    
    'notification_subject-user_password_reset'      =>  'Resetowanie hasła w serwisie Aukcyjki',
    
    'notification_message-user_password_reset'      =>  'Witaj %%' . ParamIdEnum::USER_FULLNAME . '%%,<br/>' .
                                                        '<br/>'.
                                                        'Wysłana została prośba o zresetowanie hasła dla konta:<br/>' .
                                                        '<br/>' .
                                                        '&nbsp;&nbsp;&nbsp;&nbsp;Nazwa użytkownika: %%' . FieldIdEnum::USER_LOGIN . '%%<br/>' .
                                                        '<br/>' . 
                                                        'Aby zresetować hasło kliknij w poniższy link i wprowadź nowe hasło dla swojego konta:<br/>' .
                                                        '<br/>' .
                                                        '<a href="%%' . ParamIdEnum::LINK . '%%">%%' . ParamIdEnum::LINK . '%%</a><br/>',
                                                        '<br/>' .
                                                        'Po zresetowaniu hasła zostaniesz automatycznie zalogowany do portalu aukcyjki.',
    
    'notification_subject-user_new_password_set'    =>  'Zmiana hasła w serwisie Aukcyjki',
    
    'notification_message-user_new_password_set'    =>  'Witaj %%' . ParamIdEnum::USER_FULLNAME . '%%,<br/>' .
                                                        '<br/>'.
                                                        'Nastąpiła zmiana hasła dla konta:<br/>' .
                                                        '<br/>' .
                                                        '&nbsp;&nbsp;&nbsp;&nbsp;Nazwa użytkownika: %%' . FieldIdEnum::USER_LOGIN . '%%<br/>'
);