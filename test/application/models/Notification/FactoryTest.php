<?php
/**
 * @class Notification_FactoryTest
 */
class Notification_FactoryTest extends TestCase_Database
{
    
    /**
     * @test
     */
    public function create()
    {
        $relatedObjectId = 12;
        $notification = Notification_Factory::create($relatedObjectId, DbEnum_Notification_Type::USER_REGISTRATION);

        $this->assertFalse($notification->exists());
        $this->assertEquals($relatedObjectId, $notification->related_object_id);
        $this->assertEquals(DbEnum_Notification_Type::USER_REGISTRATION, $notification->type);
    }
}
