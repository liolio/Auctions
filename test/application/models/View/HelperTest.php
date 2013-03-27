<?php
/**
 * @class View_HelperTest
 */
class View_HelperTest extends TestCase_NoDatabase
{
    
    /**
     * @test
     * @dataProvider errorMessageProvider
     */
    public function getErrorMessage($message, $expectedMessage)
    {
        $this->assertEquals($expectedMessage, View_Helper::getErrorMessage($message));
    }
    
    public function errorMessageProvider()
    {
        return array(
            array(null, null),
            array("asd", '<div class="ui-state-error ui-corner-all errorMessage">asd</div>'),
        );
    }
    
}
