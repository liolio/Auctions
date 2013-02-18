<?php
/**
 * @class Notification_Message_Builder
 */
class Notification_Message_Builder
{

    /**
     * @var Zend_Translate
     */
    private $_translator;
    
    /**
     * @var string
     */
    private $_notificationType;
    
    /**
     * @var Array
     */
    private $_notificationData;

    /**
     * 
     * @param Notification_RelatedObject_Interface $relatedObject
     * @param string $notificationType must be one of Enum_Db_Notification_Type enums
     * @throws InvalidArgumentException
     */
    public function __construct(Notification_RelatedObject_Interface $relatedObject, $notificationType)
    {
        if (!Enum_Db_Notification_Type::hasEnum($notificationType))
            throw new InvalidArgumentException('Notification type must be one of Enum_Db_Notification_Type enums.');
        
        $this->_translator = Zend_Registry::get('Zend_Translate');
        
        $this->_notificationType = $notificationType;
        
        $this->_notificationData = $this->_formatNotificationDataArray($relatedObject->getNotificationData($this->_notificationType));
    }
    
    /**
     * Builds notification body from related object notification data for given notification type.
     * 
     * @return string
     */
    public function buildBodyForNotificationType()
    {
        $messageTemplate = $this->_translator->translate('notification_message-' . $this->_notificationType);
        
        return $this->_translator->translate('notification-header') . 
            str_replace(array_keys($this->_notificationData), array_values($this->_notificationData), $messageTemplate) . 
            $this->_translator->translate('notification-footer');
    }
    
    /**
     * Builds notification body from related object notification data for given notification type.
     * 
     * @return string
     */
    public function buildSubjectForNotificationType()
    {
        $messageTemplate = $this->_translator->translate('notification_subject-' . $this->_notificationType);
        
        return str_replace(array_keys($this->_notificationData), array_values($this->_notificationData), $messageTemplate);
    }
    
    /**
     * Replaces all keys to %%key%%.
     * 
     * @param array $notificationData
     * @return array
     */
    private function _formatNotificationDataArray(array $notificationData)
    {
        foreach($notificationData as $key => $value)
        {
            $notificationData['%%' . $key . '%%'] = $value;
            unset($notificationData[$key]);
        }
        
        return $notificationData;
    }
}
