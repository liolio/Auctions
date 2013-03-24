<?php
/**
 * @class Menu_Element
 */
class Menu_Element
{
    
    /**
     *
     * @var array
     */
    private $_enabledFor = array();

    /**
     *
     * @var string
     */
    private $_route;

    /**
     *
     * @var string
     */
    private $_routeName;

    /**
     *
     * @var string
     */
    private $_description;
    
    /**
     *
     * @param string $route
     * @param string $description
     */
    public function __construct($route, $routeName, $description) {
        $this->_route = $route;
        $this->_routeName = $routeName;
        $this->_description = Helper::getTranslator()->translate($description);
        
        $reflection = new ReflectionClass('Enum_Acl_Role');
        
        foreach($reflection->getConstants() as $role) {
            $this->_enabledFor[$role] = false;
        }
        
        Zend_Controller_Front::getInstance()->getRouter()->getRoute($routeName);
    }
    
    /**
     *
     * @param string $route
     * @param string $description
     */
    static public function create($route, $routeName, $description)
    {
        return new Menu_Element($route, $routeName, $description);
    }
    
    /**
     *
     * @param string $role one of constant value from Enum_Acl_Role
     * @return Menu_Element
     * @throws InvalidArgumentException when Role is not one of Enum_Acl_Role
     */
    public function enableFor($role)
    {
        if (!array_key_exists($role, $this->_enabledFor))
            throw new InvalidArgumentException('Role "' . $role . '" doesn\'t exist.');
        
        $this->_enabledFor[$role] = true;

        return $this;
    }
    
    /**
     * Check if Menu_Element is enable for given role.
     *
     * @param string $role one of constant value from Enum_Acl_Role
     * @return boolean
     * @throws Acl_Exception
     */
    public function isEnabledFor($role)
    {
        if (!array_key_exists($role, $this->_enabledFor))
            throw new InvalidArgumentException('Role "' . $role . '" doesn\'t exist.');

        return $this->_enabledFor[$role];
    }
    
    /**
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->_description;
    }

    /**
     *
     * @return string
     */
    public function getRoute()
    {
        return $this->_route;
    }
    
    public function isActive()
    {
        return $this->_routeName === Zend_Controller_Front::getInstance()->getRouter()->getCurrentRouteName();
    }
}
