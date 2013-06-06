<?php
/**
 * @class AddressTest
 */
class AddressTest extends TestCase_Database
{
    /**
     * @test
     */
    public function getOneLineInfo()
    {
        $this->assertContains(
            "Admin Adminowy, Ulica 2, 30-002 Krak",
            AddressTable::getInstance()->find(1)->getOneLineInfo()
        );
    }
}
