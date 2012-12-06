<?php
/**
 * @class Notification_Sender
 */
class Notification_Sender
{

    public function send(Notification_RelatedObject_Interface $relatedObject, $notificationType)
    {
        if (!Enum_Db_Notification_Type::hasEnum($notificationType))
            throw new InvalidArgumentException('Notification type must be one of Enum_Db_Notification_Type enums.');
        
        $notification = Notification_Factory::create($relatedObject->getRelatedObjectId(), $notificationType);
        $notification->save();
        
        $messageBuilder = new Notification_Message_Builder($relatedObject, $notificationType);
        
        $mailClient = new Zend_Mail('UTF-8');
        $mailClient->setFrom('lio_lio@wp.pl');
        $mailClient->setSubject($messageBuilder->buildSubjectForNotificationType());
        $mailClient->setBodyHtml($messageBuilder->buildBodyForNotificationType());
        
        foreach($relatedObject->getRecipients() as $recipient)
        {
            $mailClient->clearRecipients();
            $mailClient->addTo($recipient);
            $mailClient->send();
        }
    }
}
