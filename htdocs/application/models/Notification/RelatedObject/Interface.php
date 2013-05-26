<?php
/**
 * @interface Notification_RelatedObject_Interface
 */
interface Notification_RelatedObject_Interface
{
    /**
     * Returns id of object related to notigication.
     * 
     * @return Integer
     */
    public function getRelatedObjectId();
    
    /**
     * Returns all data, which will be required for notifiaction.
     * 
     * @param Enum_Db_Notification_Type $notificationType
     * @return array
     */
    public function getNotificationData($notificationType);
    
    /**
     * Returns all recipients for notification.
     * 
     * @param Enum_Db_Notification_Type $notificationType
     * @return array
     */
    public function getRecipients($notificationType);
}
