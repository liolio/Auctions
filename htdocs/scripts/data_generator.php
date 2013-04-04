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

DataGenerator::insertAuctions(800);

class DataGenerator
{
    
    public static function insertAuctions($items)
    {
        $createdAuctionsCount = 0;
        $createdAuctionTransactionTypesCount = 0;
        
        $auctionsInDatabaseCount = AuctionTable::getInstance()->count();
        $categoriesInDatabaseCount = CategoryTable::getInstance()->count();
        
        for ($i = $auctionsInDatabaseCount + 1; $i < $auctionsInDatabaseCount + 1 + $items; $i++)
        {
            $auction = new Auction();
            $auction->user_id = 1;
            $auction->category_id = rand(1, $categoriesInDatabaseCount);
            $auction->title = "Title " . $i;
            $auction->description = "Description " . $i;
            $auction->number_of_items = rand(1, 4);
            $auction->start_time = Zend_Date::now()->addHour(rand(1, 10) * (rand(0, 1) == 1 ? 1 : -1))->toString(Time_Format::getFullDateTimeFormat());
            $auction->duration = Enum_Db_Auction_Duration::DURATION_7;
            $auction->save();
            
            if (rand(0,1) == 1)
            {
                self::_insertAuctionTransactionType($createdAuctionTransactionTypesCount, $auction, 1);
                self::_insertAuctionTransactionType($createdAuctionTransactionTypesCount, $auction, 2);
            }
            else
                self::_insertAuctionTransactionType($createdAuctionTransactionTypesCount, $auction, rand(1, 2));
            $createdAuctionsCount++;
        }

        self::_printSummary("Auction", $createdAuctionsCount);
        self::_printSummary("AuctionTransactionType", $createdAuctionTransactionTypesCount);
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
    
    private static function _printSummary($objectName, $count)
    {
        echo "Created " . $count . " " . $objectName . " objects\n";
    }
}