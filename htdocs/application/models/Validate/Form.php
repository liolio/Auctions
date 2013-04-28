<?php
/**
 * @interface Validate_Form
 */
abstract class Validate_Form
{
    
    /**
     *
     * @var String | null
     */
    private $_message;
    
    /**
     * Returns true if and only if $form meets the validation requirements
     *
     * @param  Zend_Form $form
     * @return boolean
     * @throws Zend_Validate_Exception If validation of $value is impossible
     */
    abstract public function isValid(Zend_Form $form);

    /**
     * Returns validation message.
     *
     * If isValid() was never called or if the most recent isValid() call
     * returned true, then this method returns null.
     *
     * @return array
     */
    public function getMessage()
    {
        return $this->_message;
    }
    
    protected function _setMessage($message)
    {
        $this->_message = $message;
    }
    
    /**
     * 
     * @return Zend_Translate
     */
    protected function _getTranslator()
    {
        return Helper::getTranslator();
    }
    
}
