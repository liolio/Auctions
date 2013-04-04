<?php
/**
 * @class CategoryTableTest
 */
class CategoryTableTest extends TestCase_Database
{
    
    /**
     * @test
     */
    public function getMainCategories()
    {
        Fixture_Loader::create("Category/1");
        Fixture_Loader::create("Category/2");
        Fixture_Loader::create("Category/3_parent_1");
        
        $categories = CategoryTable::getInstance()->getMainCategories();
        $this->assertEquals(2, $categories->count());
        
        $this->_assertCategory($categories->get(0), "2", "aa_main_category_2", "description_of_main_category_2");
        $this->_assertCategory($categories->get(1), "1", "zz_main_category_1", "description_of_main_category_1");
    }
    
    /**
     * @test
     */
    public function getCategoriesList()
    {
        Fixture_Loader::create("Category/1");
        Fixture_Loader::create("Category/2");
        Fixture_Loader::create("Category/3_parent_1");
        Fixture_Loader::create("Category/4_parent_1");
        Fixture_Loader::create("Category/5_parent_3");
        Fixture_Loader::create("Category/6_parent_3");
        
        $expectedArray = array(
            2   =>  array(
                FieldIdEnum::CATEGORY_ID                    =>  '2',
                FieldIdEnum::CATEGORY_DESCRIPTION           =>  'description_of_main_category_2',
                FieldIdEnum::CATEGORY_NAME                  =>  '- aa_main_category_2',
                FieldIdEnum::CATEGORY_PARENT_CATEGORY_ID    =>  null,
            ),
            1   =>  array(
                FieldIdEnum::CATEGORY_ID                    =>  '1',
                FieldIdEnum::CATEGORY_DESCRIPTION           =>  'description_of_main_category_1',
                FieldIdEnum::CATEGORY_NAME                  =>  '- zz_main_category_1',
                FieldIdEnum::CATEGORY_PARENT_CATEGORY_ID    =>  null,
            ),
            4   =>  array(
                FieldIdEnum::CATEGORY_ID                    =>  '4',
                FieldIdEnum::CATEGORY_DESCRIPTION           =>  'description_of_sub_category_4',
                FieldIdEnum::CATEGORY_NAME                  =>  '- - aa_sub_category_4',
                FieldIdEnum::CATEGORY_PARENT_CATEGORY_ID    =>  '1',
            ),
            3   =>  array(
                FieldIdEnum::CATEGORY_ID                    =>  '3',
                FieldIdEnum::CATEGORY_DESCRIPTION           =>  'description_of_sub_category_3',
                FieldIdEnum::CATEGORY_NAME                  =>  '- - zz_sub_category_3',
                FieldIdEnum::CATEGORY_PARENT_CATEGORY_ID    =>  '1',
            ),
            6   =>  array(
                FieldIdEnum::CATEGORY_ID                    =>  '6',
                FieldIdEnum::CATEGORY_DESCRIPTION           =>  'description_of_sub_sub_category_6',
                FieldIdEnum::CATEGORY_NAME                  =>  '- - - aa_sub_sub_category_6',
                FieldIdEnum::CATEGORY_PARENT_CATEGORY_ID    =>  '3',
            ),
            5   =>  array(
                FieldIdEnum::CATEGORY_ID                    =>  '5',
                FieldIdEnum::CATEGORY_DESCRIPTION           =>  'description_of_sub_sub_category_5',
                FieldIdEnum::CATEGORY_NAME                  =>  '- - - zz_sub_sub_category_5',
                FieldIdEnum::CATEGORY_PARENT_CATEGORY_ID    =>  '3',
            ),
        );
        
        $this->assertEquals($expectedArray, CategoryTable::getInstance()->getCategoriesList());
    }
    
    /**
     * @test
     * @dataProvider withoutCategoryIdProvider
     */
    public function getCategoriesListToList($withoutCategoryId, array $expectedArray)
    {
        Fixture_Loader::create("Category/1");
        Fixture_Loader::create("Category/2");
        Fixture_Loader::create("Category/3_parent_1");
        Fixture_Loader::create("Category/4_parent_1");
        Fixture_Loader::create("Category/5_parent_3");
        Fixture_Loader::create("Category/6_parent_3");
        
        $this->assertSame($expectedArray, CategoryTable::getInstance()->getCategoriesListToList($withoutCategoryId));
    }
    
    public function withoutCategoryIdProvider()
    {
        return array(
            array(
                null,
                array(
                    ParamIdEnum::CATEGORY_MAIN_CATEGORY_PARENT_ID   =>  $this->_getTranslator()->translate('caption-category_main'),
                    2   =>  '- aa_main_category_2',
                    1   =>  '- zz_main_category_1',
                    4   =>  '- - aa_sub_category_4',
                    3   =>  '- - zz_sub_category_3',
                    6   =>  '- - - aa_sub_sub_category_6',
                    5   =>  '- - - zz_sub_sub_category_5',
                )
            ),
            array(
                '5',
                array(
                    ParamIdEnum::CATEGORY_MAIN_CATEGORY_PARENT_ID   =>  $this->_getTranslator()->translate('caption-category_main'),
                    2   =>  '- aa_main_category_2',
                    1   =>  '- zz_main_category_1',
                    4   =>  '- - aa_sub_category_4',
                    3   =>  '- - zz_sub_category_3',
                    6   =>  '- - - aa_sub_sub_category_6',
                )
            ),
            array(
                '3',
                array(
                    ParamIdEnum::CATEGORY_MAIN_CATEGORY_PARENT_ID   =>  $this->_getTranslator()->translate('caption-category_main'),
                    2   =>  '- aa_main_category_2',
                    1   =>  '- zz_main_category_1',
                    4   =>  '- - aa_sub_category_4',
                )
            ),
            array(
                '2',
                array(
                    ParamIdEnum::CATEGORY_MAIN_CATEGORY_PARENT_ID   =>  $this->_getTranslator()->translate('caption-category_main'),
                    1   =>  '- zz_main_category_1',
                    4   =>  '- - aa_sub_category_4',
                    3   =>  '- - zz_sub_category_3',
                    6   =>  '- - - aa_sub_sub_category_6',
                    5   =>  '- - - zz_sub_sub_category_5',
                ),
            )
        );
    }
    
    /**
     * @test
     * @dataProvider categoryIdsToExpandProvider
     */
    public function getCategoriesToExpand($categoryId, array $categoryIds)
    {
        Fixture_Loader::create("Category/1");
        Fixture_Loader::create("Category/2");
        Fixture_Loader::create("Category/3_parent_1");
        Fixture_Loader::create("Category/4_parent_1");
        Fixture_Loader::create("Category/5_parent_3");
        Fixture_Loader::create("Category/6_parent_3");
        
        $category = CategoryTable::getInstance()->find($categoryId);
        
        $this->assertEquals($categoryIds, CategoryTable::getInstance()->getCategoriesToExpand($category));
    }
    
    public function categoryIdsToExpandProvider()
    {
        return array(
            array(1, array(3, 4, 2, 1)),
            array(3, array(5, 6, 3, 4)),
            array(5, array(5, 6))
        );
    }
    
    private function _assertCategory(Category $category, $id, $name, $description)
    {
        $this->assertEquals($id, $category->id);
        $this->assertEquals($name, $category->name);
        $this->assertEquals($description, $category->description);
    }
    
}
