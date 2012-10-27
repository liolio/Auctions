<?php

/**
 * @class HelperTest
 */
class HelperTest extends TestCase_NoDatabase
{
    
    /**
     * @test
     */
    public function getTranslator()
    {
        $this->assertEquals(
            Helper::getTranslator()->translate('application_name'),
            Zend_Registry::get("Zend_Translate")->translate('application_name')
        );
    }
}
