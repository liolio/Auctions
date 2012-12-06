<?php
/**
 * @class Notification_Factory
 */
class Notification_Factory
{
    
    /**
     * Creates new Notification object.
     * 
     * @param String $relatedObjectId
     * @param Enum_Db_Notification_Type $notificationType
     * @return Notification
     */
    public static function create($relatedObjectId, $notificationType)
    {
        $notification = new Notification();
        
        $notification->type = $notificationType;
        $notification->related_object_id = $relatedObjectId;
        
        return $notification;
    }
}
