<?php
/**
 * @class Validate_File_Extension
 */
class Validate_File_Extension extends Zend_Validate_File_Extension
{
    
    public function __construct($options = array())
    {
        $this->_messageTemplates[self::FALSE_EXTENSION] = Helper::getTranslator()->translate('validation_message-file_false_extension');
        $this->_messageTemplates[self::NOT_FOUND] = Helper::getTranslator()->translate('validation_message-file_not_found');
        
        parent::__construct($options);
    }
    
}
