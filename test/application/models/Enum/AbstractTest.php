<?php

/**
 * @class AbstractTest
 */
class Enum_AbstractTest extends TestCase_NoDatabase
{
    /**
     * @test
     * @dataProvider dataProvider
     */
    public function hasEnum($enum, $result)
    {
        $this->assertEquals($result, Enum_AbstractMock::hasEnum($enum));
    }
    
    public function dataProvider()
    {
        return array(
            array(Enum_AbstractMock::TEST, true),
            array('super', true),
            array('non_existing', false),
            array(null, false),
            array(false, false),
            array(array(), false),
        );
    }
    
    /**
     * @test
     */
    public function getEnums() {
        $this->assertEquals(
            array(
                'TEST'  =>  'test',
                'SUPER' =>  'super'
            ), 
            Enum_AbstractMock::getEnums()
        );
    }
}

class Enum_AbstractMock extends Enum_Abstract
{
    const TEST = 'test';
    
    const SUPER = 'super';
    
    private function __construct()
    {
    }
}
