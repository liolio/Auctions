<?php
/**
 * @class Auth_Result
 */
class Auth_Result extends Zend_Auth_Result
{
    
    const FAILURE_NOT_ACTIVE = -5;
    
    public function __construct($code, $identity, array $messages = array())
    {
        parent::__construct($code, $identity, $messages);

        switch ($code)
        {
            case self::FAILURE_NOT_ACTIVE:
                $this->_code = self::FAILURE_NOT_ACTIVE;
                break;
        }
    }
}
