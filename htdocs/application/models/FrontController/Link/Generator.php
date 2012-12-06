<?php
/**
 * @class FrontController_Link_Generator
 */
class FrontController_Link_Generator
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
            default :
                throw new InvalidArgumentException('Notification type must be one of Enum_Db_Notification_Type');
        }
        
        $link = $baseUrl . '/' . $actionName;
        
        if (!is_null($additionalValue))
            $link .= '/' . $additionalValue;
        
        return $link;
    }
}
