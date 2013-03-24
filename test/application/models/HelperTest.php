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
        $this->assertTrue(Helper::getTranslator() instanceof Zend_Translate);
    }
}
