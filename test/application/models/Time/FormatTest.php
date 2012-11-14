<?php
/**
 * @class Time_FormatTest
 */
class Time_FormatTest extends TestCase_NoDatabase
{
    
    /**
     * @test
     */
    public function getFullDateTimeFormat()
    {
        $this->assertEquals(
                'y-MM-dd HH:mm:ss',
                Time_Format::getFullDateTimeFormat()
        );
    }
}
