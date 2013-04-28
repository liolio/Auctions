<?php
/**
 * @class Validate_Form_Container
 */
class Validate_Form_Container extends Validate_Form
{
    
    const MODE_OR = 'mode_or';
    
    const MODE_AND = 'mode_and';
    
    /**
     * @var Validate_Form[]
     */
    private $_validators = array();
    
    private $_mode;
    
    public function __construct($mode)
    {
        $this->_mode = $mode;
    }

    public function addValidator(Validate_Form $validator)
    {
        $this->_validators[] = $validator;
    }
    
    public function isValid(Zend_Form $form)
    {
        switch ($this->_mode)
        {
            case self::MODE_AND :
                return $this->_modeAnd($form);
                
            case self::MODE_OR :
                return $this->_modeOr($form);
                
            default :
                throw new InvalidArgumentException('Mode not supported yet: ' . $this->_mode);
        }
    }
    
    private function _modeOr($form)
    {
        foreach ($this->_validators as $validator)
        {
            if (!$validator->isValid($form))
            {
                $this->_setMessage($validator->getMessage());
                return false;
            }
        }
        
        return true;
    }
    
    private function _modeAnd($form)
    {
        foreach ($this->_validators as $validator)
        {
            if (!$validator->isValid($form))
                $this->_setMessage($this->getMessage() . $validator->getMessage() . '<BR/>');
        }
        
        if (!is_null($this->getMessage()))
        {
            $this->_setMessage(substr($this->getMessage(), 0, -strlen('<BR/>')));
            return false;
        }
        
        return true;
    }
    
}
