<?php
/**
 * @class Auction_DurationTest
 */
class Auction_DurationTest extends TestCase_NoDatabase
{
    
    /**
     * @test
     */
    public function getDurationListToList()
    {
        $expected = array(
            Enum_Db_Auction_Duration::DURATION_1    =>  $this->_getDurationTranslation(Enum_Db_Auction_Duration::DURATION_1),
            Enum_Db_Auction_Duration::DURATION_3    =>  $this->_getDurationTranslation(Enum_Db_Auction_Duration::DURATION_3),
            Enum_Db_Auction_Duration::DURATION_7    =>  $this->_getDurationTranslation(Enum_Db_Auction_Duration::DURATION_7),
            Enum_Db_Auction_Duration::DURATION_14   =>  $this->_getDurationTranslation(Enum_Db_Auction_Duration::DURATION_14),
            Enum_Db_Auction_Duration::DURATION_21   =>  $this->_getDurationTranslation(Enum_Db_Auction_Duration::DURATION_21),
            Enum_Db_Auction_Duration::DURATION_30   =>  $this->_getDurationTranslation(Enum_Db_Auction_Duration::DURATION_30),
        );
        
        $this->assertEquals($expected, Auction_Duration::getDurationListToList());
    }
    
    private function _getDurationTranslation($durationEnum)
    {
        return $this->_getTranslator()->translate('enum-db_auction_duration_' . $durationEnum);
    }
}
