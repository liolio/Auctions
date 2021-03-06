<?php

/**
 * DeliveryForm
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7691 2011-02-04 15:43:29Z jwage $
 */
class DeliveryForm extends BaseDeliveryForm implements Notification_RelatedObject_Interface
{
    
    public function getNotificationData($notificationType)
    {
        switch ($notificationType)
        {
            case Enum_Db_Notification_Type::DELIVERY_FROM_FILLED_AUCTION_OWNER :
                return array(
                    FieldIdEnum::USER_LOGIN                     =>  $this->Transaction->User->login,
                    ParamIdEnum::USER_FULLNAME                  =>  $this->Transaction->AuctionTransactionType->Auction->User->getFullName(),
                    FieldIdEnum::AUCTION_TITLE                  =>  $this->Transaction->AuctionTransactionType->Auction->title,
                    ParamIdEnum::LINK                           =>  Controller_Front_UrlGenerator::generate(Controller_Front_UrlGenerator::AUCTION_SHOW, $this->Transaction->AuctionTransactionType->Auction->id),
                    FieldIdEnum::ADDRESS_NAME                   =>  $this->Address->name,
                    FieldIdEnum::ADDRESS_SURNAME                =>  $this->Address->surname,
                    FieldIdEnum::ADDRESS_STREET                 =>  $this->Address->street,
                    FieldIdEnum::ADDRESS_POSTAL_CODE            =>  $this->Address->postal_code,
                    FieldIdEnum::ADDRESS_CITY                   =>  $this->Address->city,
                    FieldIdEnum::ADDRESS_PROVINCE               =>  $this->Address->province,
                    FieldIdEnum::ADDRESS_COUNTRY                =>  $this->Address->country,
                    FieldIdEnum::ADDRESS_PHONE_NUMBER           =>  $this->Address->phone_number,
                    FieldIdEnum::DELIVERY_FORM_COMMENT          =>  $this->_formatToHtml($this->comment),
                    FieldIdEnum::TRANSACTION_PRICE              =>  Formatter_Price::formatWithCurrency($this->Transaction->price, $this->Transaction->AuctionTransactionType->Auction->Currency->name),
                    FieldIdEnum::DELIVERY_TYPE_NAME             =>  $this->Delivery->DeliveryType->name,
                    FieldIdEnum::DELIVERY_PRICE                 =>  Formatter_Price::formatWithCurrency($this->Delivery->price, $this->Transaction->AuctionTransactionType->Auction->Currency->name),
                    FieldIdEnum::DELIVERY_TYPE_CASH_ON_DELIVERY =>  Formatter_YesNo::format($this->Delivery->DeliveryType->cash_on_delivery),
                    ParamIdEnum::LINK2                          =>  Controller_Front_UrlGenerator::generate(Controller_Front_UrlGenerator::USER_PANEL_DELIVERIES),
                );
                
            default :
                throw new InvalidArgumentException('Notification type ' . $notificationType . ' is not supported.');
        }
    }

    public function getRecipients($notificationType)
    {
        switch ($notificationType)
        {
            case Enum_Db_Notification_Type::DELIVERY_FROM_FILLED_AUCTION_OWNER :
                return array($this->Transaction->AuctionTransactionType->Auction->User->email);
                
            default :
                throw new InvalidArgumentException('Notification type ' . $notificationType . ' is not supported.');
        }
    }

    public function getRelatedObjectId()
    {
        return $this->id;
    }
    
    private function _formatToHtml($value)
    {
        return str_replace(
            array(
                '\n',
                '
',
                '\t'
            ), 
            array(
                '<br/>&nbsp;&nbsp;&nbsp;&nbsp;',
                '<br/>&nbsp;&nbsp;&nbsp;&nbsp;',
                '&nbsp;&nbsp;&nbsp;&nbsp;'
            ), 
            $value);
        
    }
}