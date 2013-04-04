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
        $this->_loadFixtures(array(
            "Category/1",
            "Category/2",
            "Category/3_parent_1",
            "Category/4_parent_1",
            "Category/5_parent_3",
            "Category/6_parent_3"
        ));
        
        $category = CategoryTable::getInstance()->find(5);
        
        $this->assertEquals(array(3, 1), $category->getCategoryAllParentIds());
    }

    /**
     * @test
     * @dataProvider categoryChildrenIdsProvider
     */
    public function getCategoryAllChildrenIds($categoryId, array $expectedChildrenIds)
    {
        $this->_loadFixture("Category/structurizedTree");
        
        $category = CategoryTable::getInstance()->find($categoryId);
        $this->assertEquals($expectedChildrenIds, $category->getCategoryAllChildrenIds());
    }
    
    public function categoryChildrenIdsProvider()
    {
        return array(
            array(1, array(2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21)),
            array(9, array(10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21)),
            array(17, array(18, 19, 20, 21)),
            array(22, array(23, 24, 25, 26, 27, 28, 29, 30)),
            array(26, array())
        );
    }
    
}
