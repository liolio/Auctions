<?php
/**
 * @class Formatter_YesNoTest
 */
class Formatter_YesNoTest extends TestCase_NoDatabase
{

    /**
     * @test
     * @dataProvider dataProvider
     */
    public function format($value, $expectedValue)
    {
        $this->assertEquals($expectedValue, Formatter_YesNo::format($value));
    }
    
    public function dataProvider()
    {
        $yes = "<font color='green'>" . $this->_getTranslator()->translate('caption-yes') . "</font>";
        $no = "<font color='red'>" . $this->_getTranslator()->translate('caption-no') . "</font>";
        
        return array(
            array(true, $yes),
            array(1, $yes),
            array("1", $yes),
            
            array("", $no),
            array("0", $no),
            array(null, $no),
            array(false, $no),
        );
    }
    
}
