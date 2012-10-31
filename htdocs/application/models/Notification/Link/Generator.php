<?php
/**
 * @class Notification_Link_Generator
 */
class Notification_Link_Generator
{
    
    /**
     * 
     * @param DbEnum_Notification_Type $notificationType
     * @param string $secretCode [optional] Default set to null
     * @return string
     * @throws InvalidArgumentException
     */
    public static function generate($notificationType, $secretCode = null)
    {
        $baseUrl = Zend_Controller_Front::getInstance()->getBaseUrl();
        
        switch ($notificationType)
        {
            case DbEnum_Notification_Type::USER_REGISTRATION :
                $actionName = 'register';
                break;
            default :
                throw new InvalidArgumentException('Notification type must be one of DbEnum_Notification_Type');
        }
        
        $link = $baseUrl . '/' . $actionName;
        
        if (!is_null($secretCode))
            $link .= '/' . $secretCode;
        
        return $link;
    }
}
