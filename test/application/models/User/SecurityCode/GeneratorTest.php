<?php
/**
 * @class User_SecurityCode_GeneratorTest
 */
class User_SecurityCode_GeneratorTest extends TestCase_NoDatabase
{

    /**
     * @test
     * @dataProvider lengthValueProvider
     */
    public function generate($length)
    {
        $this->assertEquals($length, strlen(User_SecurityCode_Generator::generate($length)));
    }
    
    public function lengthValueProvider()
    {
        
        return array(
            array(1),
            array(40),
            array(55),
            array(79),
            array(81),
            array(321)
        );
    }

    /**
     * @test
     * @dataProvider lengthInvalidValuesProvider
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Length must be positive integer greater than 0
     */
    public function generateWithInvalidValues($length)
    {
        User_SecurityCode_Generator::generate($length);
    }
    
    public function lengthInvalidValuesProvider()
    {
        
        return array(
            array(-1),
            array(0),
            array('1'),
            array(array()),
            array(null),
            array('0')
        );
    }
}
