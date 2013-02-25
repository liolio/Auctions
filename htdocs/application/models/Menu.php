<?php
/**
 * @class Menu
 */
class Menu implements Iterator
{
    
    /**
     *
     * @var Menu_Element[]
     */
    private $_menuElements = array();
    
    /**
     *
     * @var Enum_Acl_Role
     */
    private $_role;
    
    public function __construct($role)
    {
        if (!Enum_Acl_Role::hasEnum($role))
            throw new InvalidArgumentException('Role "' . $role . '" doesn\'t exist.');
        
        $this->_role = $role;
    }
    
    /**
     * Add element to menu.
     *
     * @param string $keyName
     * @param Menu_Element $menuElement
     * @return Menu 
     */
    public function addElement($keyName, Menu_Element $menuElement)
    {
        $this->_menuElements[$keyName] = $menuElement;
        return $this;
    }
    
    /**
     * Remove Menu_Element object from menu array.
     *
     * @param string $keyName
     * @return Menu 
     */
    public function removeElement($keyName)
    {
        if (array_key_exists($keyName, $this->_menuElements))
            unset($this->_menuElements[$keyName]);

        return $this;
    }
    
    public function current()
    {
        return current($this->_menuElements);
    }

    public function key()
    {
        return key($this->_menuElements);
    }

    public function next()
    {
        next($this->_menuElements);
    }

    public function rewind()
    {
        reset($this->_menuElements);
    }

    public function valid()
    {
        $key = key($this->_menuElements);

        while ($key !== null && $key !== false)
        {
            if ($this->_menuElements[$key]->isEnabledFor($this->_role))
                return true;

            $this->next();
            $key = key($this->_menuElements);
        }
        
        return false;
    }
}
