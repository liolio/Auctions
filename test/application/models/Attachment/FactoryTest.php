<?php
/**
 * @class Attachment_FactoryTest
 */
class Attachment_FactoryTest extends TestCase_Database
{
    /**
     * @test
     */
    public function create()
    {
        $this->_loadFixtures(array(
            'Category/1',
            'Currency/1',
            'Auction/1_category_1_start_2012-05-02',
            'File/1'
        ));
        
        $auction = AuctionTable::getInstance()->find(1);
        $file = FileTable::getInstance()->find(1);
        
        $attachment = Attachment_Factory::create($auction, $file);
        
        $this->assertEquals('Auction 1', $attachment->Auction->title);
        $this->assertEquals('filename_1', $attachment->File->filename);
    }
}
