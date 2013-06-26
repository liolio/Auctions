<?php
/**
 * @class Session_DialogWindow
 */
class Session_DialogWindow
{
    
    CONST NAME_SPACE = "dialog_window";
    
    public static function save($url) {
        $nameSpace = new Zend_Session_Namespace(self::NAME_SPACE);
        $nameSpace->last = $url;
    }

    public static function getValue() {
        $nameSpace = new Zend_Session_Namespace(self::NAME_SPACE);
        
        if (!empty($nameSpace->last)) {
            $path = $nameSpace->last;
            $nameSpace->unsetAll();
        
            return $path;
        }

        return '';
     }
}
