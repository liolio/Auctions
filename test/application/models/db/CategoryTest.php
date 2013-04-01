<?php
/**
 * @class CategoryTest
 */
class CategoryTest extends TestCase_Database
{

    /**
     * @test
     */
    public function getCategoryAllParentIds()
    {
        Fixture_Loader::create("Category/1");
        Fixture_Loader::create("Category/2");
        Fixture_Loader::create("Category/3_parent_1");
        Fixture_Loader::create("Category/4_parent_1");
        Fixture_Loader::create("Category/5_parent_3");
        Fixture_Loader::create("Category/6_parent_3");
        
        $category = CategoryTable::getInstance()->find(5);
        
        $this->assertEquals(array(3, 1), $category->getCategoryAllParentIds());
    }
}
