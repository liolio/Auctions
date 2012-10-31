<?php
/**
 * @class DbEnum_Notification_TypeTest
 */
class DbEnum_Notification_TypeTest extends TestCase_NoDatabase
{

    /**
     * @test
     * @dataProvider dataProvider
     */
    public function hasEnum($enum, $result)
    {
        $this->assertEquals($result, DbEnum_Notification_Type::hasEnum($enum));
    }
    
    public function dataProvider()
    {
        return array(
            array(DbEnum_Notification_Type::USER_REGISTRATION, true),
            array('non_existing', false),
            array(null, false),
            array(false, false),
            array(array(), false),
        );
    }
}
