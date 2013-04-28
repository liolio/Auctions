<?php
/**
 * @class Attachment_Factory
 */
class Attachment_Factory
{
    
    public static function create(Auction $auction, File $file)
    {
        $attachment = new Attachment();
        
        $attachment->Auction = $auction;
        $attachment->File = $file;
        
        return $attachment;
    }
    
}
