<?php
/**
 * @class Auction_Factory
 */
class Auction_Factory
{
    
    public static function create(array $data, Category $category, Currency $currency, User $user, $thumbnail)
    {
        $auction = new Auction();
        $auction->title = $data[FieldIdEnum::AUCTION_TITLE];
        $auction->description = $data[FieldIdEnum::AUCTION_DESCRIPTION];
        $auction->duration = $data[FieldIdEnum::AUCTION_DURATION];
        $auction->start_time = $data[FieldIdEnum::AUCTION_START_TIME];
        $auction->number_of_items = $data[FieldIdEnum::AUCTION_NUMBER_OF_ITEMS];
        
        $category->refresh(true);
        
        $auction->Category = $category;
        $auction->Currency = $currency;
        $auction->User = $user;
        $auction->File = $thumbnail;
        
        return $auction;
    }
}
