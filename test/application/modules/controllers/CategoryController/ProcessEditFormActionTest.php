<?php
/**
 * @class Auctions_CategoryController_ProcessEditFormActionTest
 */
class Auctions_CategoryController_ProcessEditFormActionTest extends TestCase_Controller
{
    
    /**
     * @test
     */
    public function process()
    {
        $this->_loadFixture("Category/1");
        $request = array(
            FieldIdEnum::CATEGORY_ID                    =>  '1',
            FieldIdEnum::CATEGORY_NAME                  =>  'new name',
            FieldIdEnum::CATEGORY_DESCRIPTION           =>  'new description',
            FieldIdEnum::CATEGORY_PARENT_CATEGORY_ID    =>  ParamIdEnum::CATEGORY_MAIN_CATEGORY_PARENT_ID
        );
        
        $this->_setRequest($request);
        
        $this->dispatch("category/process-edit-form");
        $this->_assertDispatch('category', 'process-edit-form');
        
        $this->_assertRedirection("category/show-administrator-list");
        
        $categories = CategoryTable::getInstance()->findAll();
        $this->assertEquals(1, count($categories));
        
        $category = $categories->get(0);
        $this->assertEquals($request[FieldIdEnum::CATEGORY_NAME], $category->name);
        $this->assertEquals($request[FieldIdEnum::CATEGORY_DESCRIPTION], $category->description);
        $this->assertNull($category->parent_category_id);
    }
    
    /**
     * @test
     */
    public function processWithInvalidData()
    {
        $this->_setRequest(array());
        
        $this->dispatch("category/process-edit-form");
        $this->_assertDispatch('category', 'process-edit-form');
        $this->assertContains(Helper::getTranslator()->translate("validation_message-field_empty"), $this->getResponse()->getBody());
        
        $this->assertEquals(0, CategoryTable::getInstance()->count());
    }
}
