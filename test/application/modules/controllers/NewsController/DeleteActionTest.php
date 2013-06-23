<?php
/**
 * @class Auctions_NewsController_DeleteActionTest
 */
class Auctions_NewsController_DeleteActionTest extends TestCase_Controller
{
    
    /**
     * @test
     */
    public function delete()
    {
        $this->_loadFixture("News/1_u_1");
        
        $this->dispatch('/news/delete/1');
        $this->_assertDispatch('news', 'delete');
        
        $this->_assertRedirection("news/show-list");
        
        $this->assertEquals(0, NewsTable::getInstance()->count());
    }
    
}
