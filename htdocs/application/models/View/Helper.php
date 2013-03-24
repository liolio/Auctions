<?php
/**
 * @class View_Helper
 */
class View_Helper
{
    
    public static function getErrorMessage($message)
    {
        return is_null($message) ? $message : '<div class="errorMessage">' . $message . '</div>';
    }
    
}
