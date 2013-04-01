<?php

/**
 * UserTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class UserTable extends Doctrine_Table
{
    /**
     * Returns an instance of this class.
     *
     * @return object UserTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('User');
    }
    
    /**
     * Checks if given email is unique. Ignoring email set for user with given user ID.
     * 
     * @param String $email
     * @param String $userId [optional] Default set to null
     * @return Boolean
     */
    public function isEmailUnique($email, $userId = null)
    {
        $query = $this->createQuery()
                ->where('email = ?', $email);
        
        if (!is_null($userId))
            $query->addWhere ('id != ?', $userId);
        
        return $query->count() === 0;
    }
    
    /**
     * Checks if given login is unique. Ignoring login set for user with given user ID.
     * 
     * @param String $email
     * @param String $userId [optional] Default set to null
     * @return Boolean
     */
    public function isLoginUnique($login, $userId = null)
    {
        $query = $this->createQuery()
                ->where('login = ?', $login);
        
        if (!is_null($userId))
            $query->addWhere ('id != ?', $userId);
        
        return $query->count() === 0;
    }
}