<?php
/**
 * @class Acl_Assertion_Abstract
 */
abstract class Acl_Assertion_Abstract
{
    
    /**
     * Array of params from request.
     * 
     * @var String[]
     */
    private $_params;
    
    /**
     * @param array $params Array of params from request.
     */
    public function __construct(array $params)
    {
        $this->_params = $params;
    }
    
    public static function getClassName()
    {
        return get_called_class();
    }
    
    protected function _getParam($paramName)
    {
        return array_key_exists($paramName, $this->_params) ? $this->_params[$paramName] : null;
    }
}
