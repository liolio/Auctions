<?php
/**
 * @class Auction_FactoryTest
 */
class Auction_FactoryTest extends TestCase_Database
{
    /**
     * @test
     */
    public function create()
    {
        $this->_loadFixtures(array(
            'Category/1',
            'Currency/1',
            'File/1'
        ));
        
        $data = array(
            FieldIdEnum::AUCTION_TITLE              =>  'title',
            FieldIdEnum::AUCTION_DESCRIPTION        =>  'description',
            FieldIdEnum::AUCTION_DURATION           =>  'duration',
            FieldIdEnum::AUCTION_START_TIME         =>  '2012-05-02 22:22:22',
            FieldIdEnum::AUCTION_NUMBER_OF_ITEMS    =>  '2',
                
        );
        
        $auction = Auction_Factory::create(
            $data,
            CategoryTable::getInstance()->find(1),
            CurrencyTable::getInstance()->find(1), 
            UserTable::getInstance()->find(1),
            FileTable::getInstance()->find(1)
        );
        
        $this->assertEquals($data[FieldIdEnum::AUCTION_TITLE], $auction->title);
        $this->assertEquals($data[FieldIdEnum::AUCTION_DESCRIPTION], $auction->description);
        $this->assertEquals($data[FieldIdEnum::AUCTION_DURATION], $auction->duration);
        $this->assertEquals($data[FieldIdEnum::AUCTION_START_TIME], $auction->start_time);
        $this->assertEquals($data[FieldIdEnum::AUCTION_NUMBER_OF_ITEMS], $auction->number_of_items);
        $this->assertEquals(1, $auction->category_id);
        $this->assertEquals(1, $auction->currency_id);
        $this->assertEquals(1, $auction->user_id);
        $this->assertEquals(1, $auction->thumbnail_file_id);
    }
}
