<?php
/**
 * @interface Notification_RelatedObject_Interface
 */
interface Notification_RelatedObject_Interface
{
    /**
     * 
     * @return Integer
     */
    public function getRelatedObjectId();
    
    /**
     * 
     * @param DbEnum_Notification_Type $notificationType
     * @return array
     */
    public function getNotificationData($notificationType);
    
    /**
     * 
     * @return array
     */
    public function getRecipients();
}
