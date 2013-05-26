<?php
/**
 * @class Session_LastVisited
 */
class Session_LastVisited
{
    
    CONST NAME_SPACE = "history";
    
    public static function save($url) {
        $nameSpace = new Zend_Session_Namespace(self::NAME_SPACE);
        $nameSpace->last = $url;
    }

    public static function getLastVisited() {
        $nameSpace = new Zend_Session_Namespace(self::NAME_SPACE);
        
        if (!empty($nameSpace->last)) {
            $path = $nameSpace->last;
            $nameSpace->unsetAll();
        
            return $path;
        }

        return '';
     }
}
