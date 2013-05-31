<?php
/**
 * @class Controller_Front_UrlGenerator
 */
class Controller_Front_UrlGenerator
{

    const USER_REGISTRATION = 'user_registration';
    
    const USER_PASSWORD_RESET = 'user_password_reset';
    
    const AUCTION_SHOW = 'auction_show';
    
    const DELIVERY_FORM_FILL = 'delivery_form_fill';
    
    /**
     * 
     * @param String $type One of Controller_Front_UrlGenerator consts
     * @param string $additionalValue [optional] Default set to null
     * @return string
     * @throws InvalidArgumentException
     */
    public static function generate($type, $additionalValue = null)
    {
        $baseUrl = Zend_Controller_Front::getInstance()->getBaseUrl();
        
        switch ($type)
        {
            case self::USER_REGISTRATION :
                $actionName = 'register';
                break;
            case self::USER_PASSWORD_RESET :
                $actionName = 'user/password-reset';
                break;
            case self::AUCTION_SHOW :
                $actionName = 'auction/show';
                break;
            case self::DELIVERY_FORM_FILL :
                $actionName = 'delivery-form/fill';
                break;
            default :
                throw new InvalidArgumentException('Type must be one of supported consts. ' . $type . ' is invalid.');
        }
        
        $link = $baseUrl . '/' . $actionName;
        
        if (!is_null($additionalValue))
            $link .= '/' . $additionalValue;
        
        return $link;
    }
}
