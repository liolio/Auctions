<?php
/**
 * @class User_Factory
 */
class User_Factory
{

    /**
     * Creates new User object.
     * 
     * @param string $login
     * @param string $email
     * @param string $securityCode [optional] Default set to null
     * @return User
     */
    public static function create($login, $email, $securityCode = null)
    {
        $user = new User();
        
        $user->login = $login;
        $user->email = $email;
        $user->secret_code = $securityCode;
        $user->salt = rand(User::SALT_MIN, User::SALT_MAX);
        $user->active = false;
        $user->password = str_repeat('0', 40);
        
        return $user;
    }
}
