<?php

/**
 * CurrencyTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class CurrencyTable extends Doctrine_Table
{
    /**
     * Returns an instance of this class.
     *
     * @return object CurrencyTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('Currency');
    }
    
    /**
     * Checks if currency name is unique (ignoring currency with given id).
     * 
     * @param String $name
     * @param String $id [optional] Default set to null
     * @return Boolean
     */
    public function isCurrencyUnique($name, $id = null)
    {
        $query = $this->createQuery()
                ->where("name = ?", $name);
        
        if (!is_null($id))
            $query->addWhere("id != ?", $id);
                
        return $query->count() === 0;
    }
}