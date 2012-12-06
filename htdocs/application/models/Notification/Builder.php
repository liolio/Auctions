<?php
/**
 * @class Notification_Builder
 */
class Notification_Builder
{

    public function build(Notification_RelatedObject_Interface $relatedObject, $notificationType)
    {
        if (!Enum_Db_Notification_Type::hasEnum($notificationType))
            throw new InvalidArgumentException('Notification type must be one of Enum_Db_Notification_Type enums.');
        
        $notification = Notification_Factory::create($relatedObject->getId(), $notificationType);
        $notification->save();
        
        $messageBuilder = new Notification_Message_Builder();
        
        $mailClient = new Zend_Mail('UTF-8');
        $mailClient->setFrom('lio_lio@wp.pl');
        $mailClient->setSubject($messageBuilder->getSubjectForNotificationType($notificationType));
        $mailClient->setBodyHtml($messageBuilder->buildForNotificationType($relatedObject, $notificationType));
        
        foreach($relatedObject->getRecipients() as $recipient)
        {
            $mailClient->clearRecipients();
            $mailClient->addTo($recipient);
            $mailClient->send();
        }
    }
}
