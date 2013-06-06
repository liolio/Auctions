<?php

/**
 * Transaction
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7691 2011-02-04 15:43:29Z jwage $
 */
class Transaction extends BaseTransaction implements Notification_RelatedObject_Interface
{

    public function getNotificationData($notificationType)
    {
        switch ($notificationType)
        {
            case Enum_Db_Notification_Type::AUCTION_BID_BIDDER :
                return array(
                    FieldIdEnum::AUCTION_TITLE                  =>  $this->AuctionTransactionType->Auction->title,
                    ParamIdEnum::USER_FULLNAME                  =>  $this->User->getFullName(),
                    ParamIdEnum::LINK                           =>  Controller_Front_UrlGenerator::generate(Controller_Front_UrlGenerator::AUCTION_SHOW, $this->AuctionTransactionType->Auction->id),
                    FieldIdEnum::TRANSACTION_NUMBER_OF_ITEMS    =>  $this->number_of_items,
                    FieldIdEnum::TRANSACTION_PRICE              =>  Formatter_Price::formatWithCurrency($this->price, $this->AuctionTransactionType->Auction->Currency->name)
                );
            case Enum_Db_Notification_Type::AUCTION_BUY_OUT_CUSTOMER :
            case Enum_Db_Notification_Type::AUCTION_BID_WINNER :
                return array(
                    FieldIdEnum::AUCTION_TITLE                  =>  $this->AuctionTransactionType->Auction->title,
                    ParamIdEnum::USER_FULLNAME                  =>  $this->User->getFullName(),
                    ParamIdEnum::LINK                           =>  Controller_Front_UrlGenerator::generate(Controller_Front_UrlGenerator::AUCTION_SHOW, $this->AuctionTransactionType->Auction->id),
                    ParamIdEnum::LINK2                          =>  Controller_Front_UrlGenerator::generate(Controller_Front_UrlGenerator::DELIVERY_FORM_FILL, $this->DeliveryForm->id),
                    FieldIdEnum::TRANSACTION_NUMBER_OF_ITEMS    =>  $this->number_of_items,
                    FieldIdEnum::TRANSACTION_PRICE              =>  Formatter_Price::formatWithCurrency($this->price, $this->AuctionTransactionType->Auction->Currency->name)
                );
            case Enum_Db_Notification_Type::AUCTION_BID_AUCTION_OWNER :
            case Enum_Db_Notification_Type::AUCTION_BUY_OUT_AUCTION_OWNER :
                return array(
                    FieldIdEnum::USER_LOGIN                     =>  $this->User->login,
                    FieldIdEnum::AUCTION_TITLE                  =>  $this->AuctionTransactionType->Auction->title,
                    ParamIdEnum::USER_FULLNAME                  =>  $this->AuctionTransactionType->Auction->User->getFullName(),
                    ParamIdEnum::LINK                           =>  Controller_Front_UrlGenerator::generate(Controller_Front_UrlGenerator::AUCTION_SHOW, $this->AuctionTransactionType->Auction->id),
                    FieldIdEnum::TRANSACTION_NUMBER_OF_ITEMS    =>  $this->number_of_items,
                    FieldIdEnum::TRANSACTION_PRICE              =>  Formatter_Price::formatWithCurrency($this->price, $this->AuctionTransactionType->Auction->Currency->name)
                );
            case Enum_Db_Notification_Type::AUCTION_BID_OUTBIDDED :
                return array(
                    FieldIdEnum::AUCTION_TITLE                  =>  $this->AuctionTransactionType->Auction->title,
                    ParamIdEnum::USER_FULLNAME                  =>  $this->AuctionTransactionType->Auction->User->getFullName(),
                    ParamIdEnum::LINK                           =>  Controller_Front_UrlGenerator::generate(Controller_Front_UrlGenerator::AUCTION_SHOW, $this->AuctionTransactionType->Auction->id),
                    FieldIdEnum::TRANSACTION_NUMBER_OF_ITEMS    =>  $this->number_of_items,
                    FieldIdEnum::TRANSACTION_PRICE              =>  Formatter_Price::formatWithCurrency($this->price, $this->AuctionTransactionType->Auction->Currency->name),
                    ParamIdEnum::AUCTION_PRICE                  =>  Formatter_Price::formatWithCurrency($this->AuctionTransactionType->countPrice(), $this->AuctionTransactionType->Auction->Currency->name)
                );
            default :
                throw new InvalidArgumentException('Notification type ' . $notificationType . ' is not supported.');
        }
    }

    public function getRecipients($notificationType)
    {
        switch ($notificationType)
        {
            case Enum_Db_Notification_Type::AUCTION_BID_BIDDER :
            case Enum_Db_Notification_Type::AUCTION_BID_OUTBIDDED :
            case Enum_Db_Notification_Type::AUCTION_BUY_OUT_CUSTOMER :
            case Enum_Db_Notification_Type::AUCTION_BID_WINNER :
                return array($this->User->email);
            case Enum_Db_Notification_Type::AUCTION_BID_AUCTION_OWNER :
            case Enum_Db_Notification_Type::AUCTION_BUY_OUT_AUCTION_OWNER :
                return array($this->AuctionTransactionType->Auction->User->email);
            default :
                throw new InvalidArgumentException('Notification type ' . $notificationType . ' is not supported.');
        }
    }

    public function getRelatedObjectId()
    {
        return $this->id;
    }
}