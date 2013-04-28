<?php
/**
 * @class Auction_Duration
 */
class Auction_Duration
{
    
    /**
     * Returns all auction's durations to list in combobox.
     * 
     * @return array
     */
    public static function getDurationListToList()
    {
        $durations = array();
        $translator = Helper::getTranslator();
        
        foreach (Enum_Db_Auction_Duration::getEnums() as $value)
            $durations[$value] = $translator->translate('enum-db_auction_duration_' . $value);
        
        return $durations;
    }
    
}
