<?php
/**
 * @class Category_FactoryTest
 */
class Category_FactoryTest extends TestCase_NoDatabase
{
    
    /**
     * @test
     */
    public function create()
    {
        $data = array(
            FieldIdEnum::CATEGORY_NAME                  =>  'c_name',
            FieldIdEnum::CATEGORY_DESCRIPTION           =>  'c_description',
            FieldIdEnum::CATEGORY_PARENT_CATEGORY_ID    =>  'c_p_id'
        );
        
        $category = Category_Factory::create($data);
        
        $this->assertEquals($data[FieldIdEnum::CATEGORY_NAME], $category->name);
        $this->assertEquals($data[FieldIdEnum::CATEGORY_DESCRIPTION], $category->description);
        $this->assertEquals($data[FieldIdEnum::CATEGORY_PARENT_CATEGORY_ID], $category->parent_category_id);
    }
}
