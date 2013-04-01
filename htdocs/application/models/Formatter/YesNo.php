<?php
/**
 * @class Formatter_YesNo
 */
class Formatter_YesNo
{
    
    /**
     * Casts value to boolean and return translated yes or no string.
     * 
     * @param String $value
     * @return String
     */
    public static function format($value)
    {
        $translator = Helper::getTranslator();
        return (bool) $value ? 
            "<font color='green'>" . $translator->translate('caption-yes') . "</font>" : 
            "<font color='red'>" . $translator->translate('caption-no') . "</font>"; 
    }
    
}
