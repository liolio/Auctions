<?php
/**
 * @class Controller_Front_UrlGenerator
 */
class Controller_Front_UrlGenerator
{
    
    /**
     * 
     * @param Enum_Db_Notification_Type $notificationType One of Enum_Db_Notification_Type
     * @param string $additionalValue [optional] Default set to null
     * @return string
     * @throws InvalidArgumentException
     */
    public static function generate($notificationType, $additionalValue = null)
    {
        $baseUrl = Zend_Controller_Front::getInstance()->getBaseUrl();
        
        switch ($notificationType)
        {
            case Enum_Db_Notification_Type::USER_REGISTRATION :
                $actionName = 'register';
                break;
            case Enum_Db_Notification_Type::USER_PASSWORD_RESET :
                $actionName = 'user/password-reset';
                break;
            case Enum_Db_Notification_Type::AUCTION_BID_BIDDER :
            case Enum_Db_Notification_Type::AUCTION_BID_AUCTION_OWNER :
            case Enum_Db_Notification_Type::AUCTION_BID_OUTBIDDED :
                $actionName = 'auction/show';
                break;
            default :
                throw new InvalidArgumentException('Notification type must be one of supported Enum_Db_Notification_Type. ' . $notificationType . ' is invalid.');
        }
        
        $link = $baseUrl . '/' . $actionName;
        
        if (!is_null($additionalValue))
            $link .= '/' . $additionalValue;
        
        return $link;
    }
}
