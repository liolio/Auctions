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
    
    public function __construct()
    {
        $this->_translator = Zend_Registry::get('Zend_Translate');
    }
    
    public function buildForNotificationType(Notification_RelatedObject_Interface $relatedObject, $notificationType)
    {
        $messageTemplate = $this->_translator->translate('notification_message-' . $notificationType);
        
        $notificationData = $this->_formatNotificationDataArray($relatedObject->getNotificationData($notificationType));
        
        return str_replace(array_keys($notificationData), array_values($notificationData), $messageTemplate);
    }
    
    public function getSubjectForNotificationType($notificationType)
    {
        return $this->_translator->translate('notification_subject-' . $notificationType);
    }
    
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
