<?php

defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../application'));

defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'development'));
//    || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));

define('DATESTAMP', date('Y-m-d'));

set_include_path(implode(PATH_SEPARATOR, array(
    realpath(APPLICATION_PATH . '/../library'),
    realpath(APPLICATION_PATH . '/models'),
    get_include_path(),
)));

if (APPLICATION_ENV !== 'production')
    error_reporting(E_ALL | E_STRICT);

/** Zend_Application */
require_once 'Zend/Application.php';

// Create application, bootstrap, and run
$application = new Zend_Application(
    APPLICATION_ENV,
    APPLICATION_PATH . '/configs/application.ini'
);

$application->bootstrap();

DataGenerator::insertAuctions(1000);

class DataGenerator
{
    public static function insertAuctions($items)
    {
        try {
            $createdAuctionsCount = 0;
            $createdAuctionTransactionTypesCount = 0;
            $createdAttachmentsCount = 0;
            $createdDeliveriesCount = 0;
            $createdTransactionsCount = 0;

            $auctionsInDatabaseCount = AuctionTable::getInstance()->count();
            $categoriesInDatabaseCount = CategoryTable::getInstance()->count();
            $currenciesInDatabaseCount = CurrencyTable::getInstance()->count();
            $usersInDatabaseCount = UserTable::getInstance()->count();
            $filesInDatabaseCount = FileTable::getInstance()->count();
            $deliveryTypesInDatabaseCount = DeliveryTypeTable::getInstance()->count();

            for ($i = $auctionsInDatabaseCount + 1; $i < $auctionsInDatabaseCount + 1 + $items; $i++)
            {
                $auction = new Auction();
                $auction->user_id = rand(1,$usersInDatabaseCount);
                $auction->currency_id = rand(1, $currenciesInDatabaseCount);
                $auction->category_id = rand(1, $categoriesInDatabaseCount);
                $auction->title = "Title " . $i;
                $auction->description = "Description " . $i;
                $auction->number_of_items = rand(1, 4);
                $auction->start_time = Zend_Date::now()->addHour(rand(1, 10) *  -1)->toString(Time_Format::getFullDateTimeFormat());
                $auction->duration = Enum_Db_Auction_Duration::DURATION_7;
                $auction->save();
                $auction->refresh();

                if (rand(0,1) == 1)
                {
                    self::_insertAuctionTransactionType($createdAuctionTransactionTypesCount, $auction, 1);
                    self::_insertAuctionTransactionType($createdAuctionTransactionTypesCount, $auction, 2);
                }
                else
                    self::_insertAuctionTransactionType($createdAuctionTransactionTypesCount, $auction, rand(1, 2));

                $fileIds = range(1, $filesInDatabaseCount);
                shuffle($fileIds);
                for ($i_att = 0; $i_att < rand(1,5); $i_att++)
                {
                    self::_insertAttachment($createdAttachmentsCount, $auction, array_pop($fileIds));
                }

                self::_updateThumbnail($auction);

                for ($i_del = 0; $i_del < rand (1,5); $i_del++)
                    self::_insertDelivery($createdDeliveriesCount, $auction, $deliveryTypesInDatabaseCount);

                for ($i_tra = 0; $i_tra < rand(0, 2); $i_tra++)
                    self::_insertTransaction($createdTransactionsCount, $auction, $usersInDatabaseCount);
                
                $createdAuctionsCount++;
            }

            self::_printSummary("Auction", $createdAuctionsCount);
            self::_printSummary("AuctionTransactionType", $createdAuctionTransactionTypesCount);
            self::_printSummary("Attachment", $createdAttachmentsCount);
            self::_printSummary("Delivery", $createdDeliveriesCount);
            self::_printSummary("Transaction", $createdTransactionsCount);
        } catch (Exception $exception) {
            echo $exception->getTraceAsString() . "\n";
            throw $exception;
        }
    }
    
    private static function _insertAuctionTransactionType(&$auctionTransactionTypesCount, Auction $auction, $transactionTypeId)
    {
        $auctionTransactionType = new AuctionTransactionType();
        $auctionTransactionType->Auction = $auction;
        $auctionTransactionType->transaction_type_id = $transactionTypeId;
        $auctionTransactionType->price = rand(10,1000) + floatval(rand(0, 99))/100;
        $auctionTransactionType->save();
        $auctionTransactionTypesCount++;
    }
    
    private static function _insertTransaction(&$transationsCount, Auction $auction, $usersCount)
    {
        $auctionTransactionType = $auction->AuctionTransactionTypes->get(rand(0, $auction->AuctionTransactionTypes->count() - 1));
        $transation = new Transaction();
        $transation->auction_transaction_type_id = $auctionTransactionType->id;
        $transation->user_id = rand(1, $usersCount);
        $transation->number_of_items = rand(1, $auction->number_of_items);
        $transation->price = $auctionTransactionType->TransactionType->name == Enum_Db_TransactionType_Type::BUY_OUT ?
                $auctionTransactionType->price :
                $auctionTransactionType->price + rand(1, 100);
        $transation->number_of_items = rand(1, $auction->number_of_items);
        $transation->save();
        $transationsCount++;
    }
    
    private static function _insertAttachment(&$attachmentsCount, Auction $auction, $filesId)
    {
        $attachment = new Attachment();
        $attachment->auction_id = $auction->id;
        $attachment->file_id = $filesId;
        $attachment->save();
        $attachmentsCount++;
    }
    
    private static function _insertDelivery(&$deliveryCount, Auction $auction, $deliveryTypeCount)
    {
        $delivery = new Delivery();
        $delivery->auction_id = $auction->id;
        $delivery->delivery_type_id = rand(1, $deliveryTypeCount);
        $delivery->price = rand(1,20) + floatval(rand(0, 99))/100;
        $delivery->save();
        $deliveryCount++;
    }
    
    private static function _updateThumbnail(Auction $auction)
    {
        $auction->thumbnail_file_id = $auction->Attachments->get(rand(0, $auction->Attachments->count()-1))->File->id;
        $auction->save();
    }
    
    private static function _printSummary($objectName, $count)
    {
        echo "Created " . $count . " " . $objectName . " objects\n";
    }
}