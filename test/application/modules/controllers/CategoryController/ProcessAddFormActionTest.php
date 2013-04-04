<?php
/**
 * @class Auctions_CategoryController_ProcessAddFormActionTest
 */
class Auctions_CategoryController_ProcessAddFormActionTest extends TestCase_Controller
{
    
    /**
     * @test
     */
    public function process()
    {
        $this->_loadFixture("Category/1");
        
        $request = array(
            FieldIdEnum::CATEGORY_NAME                  =>  'name',
            FieldIdEnum::CATEGORY_DESCRIPTION           =>  'description',
            FieldIdEnum::CATEGORY_PARENT_CATEGORY_ID    =>  '1',
        );
        
        $this->_setRequest($request);
        
        $this->dispatch("category/process-add-form");
        $this->_assertDispatch('category', 'process-add-form');
        
        $this->_assertRedirection("category/show-administrator-list");
        
        $categories = CategoryTable::getInstance()->findAll();
        $this->assertEquals(2, count($categories));
        
        $category = $categories->get(1);
        $this->assertEquals($request[FieldIdEnum::CATEGORY_NAME], $category->name);
        $this->assertEquals($request[FieldIdEnum::CATEGORY_DESCRIPTION], $category->description);
        $this->assertEquals($request[FieldIdEnum::CATEGORY_PARENT_CATEGORY_ID], $category->parent_category_id);
    }
    
    /**
     * @test
     */
    public function processWithInvalidData()
    {
        $this->_setRequest(array());
        
        $this->dispatch("category/process-add-form");
        $this->_assertDispatch('category', 'process-add-form');
        $this->assertContains(Helper::getTranslator()->translate("validation_message-field_empty"), $this->getResponse()->getBody());
        
        $this->assertEquals(0, CategoryTable::getInstance()->count());
    }
}
