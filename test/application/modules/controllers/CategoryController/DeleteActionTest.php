<?php
/**
 * @class Auctions_CategoryController_DeleteActionTest
 */
class Auctions_CategoryController_DeleteActionTest extends TestCase_Controller
{
    
    /**
     * @test
     */
    public function deleteLastAddress()
    {
        Fixture_Loader::create("Category/1");
        Fixture_Loader::create("Category/3_parent_1");
        
        $this->dispatch('/category/delete/1');
        $this->_assertDispatch('category', 'delete');
        
        $this->assertContains(
            Helper::getTranslator()->translate('validation_message-cannot_delete_category_has_subcategories'),
            $this->getResponse()->getBody()
        );
        
        $this->assertEquals(2, CategoryTable::getInstance()->count());
    }
    
    /**
     * @test
     */
    public function delete()
    {
        Fixture_Loader::create("Category/1");
        
        $this->dispatch('/category/delete/1');
        $this->_assertDispatch('category', 'delete');
        
        $this->_assertRedirection("category/show-administrator-list");
        
        $this->assertEquals(0, CategoryTable::getInstance()->count());
    }
}
