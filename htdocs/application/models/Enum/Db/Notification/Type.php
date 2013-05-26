<?php
/**
 * @class Enum_Db_Notification_Type
 */
class Enum_Db_Notification_Type extends Enum_Abstract
{

    const AUCTION_BID_BIDDER = 'auction_bid_bidder';
    
    const AUCTION_BID_AUCTION_OWNER = 'auction_bid_auction_owner';
    
    const AUCTION_BID_OUTBIDDED = 'auction_bid_outbidded';
    
    const AUCTION_BUY_OUT_CUSTOMER = 'auction_buy_out_customer';
    
    const AUCTION_BUY_OUT_AUCTION_OWNER = 'auction_buy_out_auction_owner';
    
    const USER_REGISTRATION = 'user_registration';
    
    const USER_PASSWORD_RESET = 'user_password_reset';
    
    const USER_NEW_PASSWORD_SET = 'user_new_password_set';
}
