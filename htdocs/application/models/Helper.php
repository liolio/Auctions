<?php
/**
 * @class Helper
 */
class Helper
{
    
    /**
     * @var Zend_Translate
     */
    private static $_translator;
    
    /**
     * @return Zend_Translate
     */
    public static function getTranslator()
    {
        if (is_null(self::$_translator))
            self::$_translator = Zend_Registry::get("Zend_Translate");
        
        return self::$_translator;
    }
}
