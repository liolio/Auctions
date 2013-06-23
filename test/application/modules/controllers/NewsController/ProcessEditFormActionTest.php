<?php
/**
 * @class Auctions_NewsController_ProcessEditFormActionTest
 */
class Auctions_NewsController_ProcessEditFormActionTest extends TestCase_Controller
{
    
    /**
     * @test
     */
    public function process()
    {
        $this->_loadFixtures(array(
            "User/2",
            "News/2_u_2"
        ));
        
        $request = array(
            FieldIdEnum::NEWS_ID            =>  '2',
            FieldIdEnum::NEWS_TITLE         =>  'new name',
            FieldIdEnum::NEWS_DESCRIPTION   =>  'new description',
        );
        
        $this->_setRequest($request);
        
        $this->dispatch("news/process-edit-form");
        $this->_assertDispatch('news', 'process-edit-form');
        
        $this->_assertRedirection("news/show-list");
        
        $newses = NewsTable::getInstance()->findAll();
        $this->assertEquals(1, count($newses));
        
        $news = $newses->get(0);
        $this->assertEquals($request[FieldIdEnum::NEWS_TITLE], $news->title);
        $this->assertEquals($request[FieldIdEnum::NEWS_DESCRIPTION], $news->description);
        $this->assertEquals('1', $news->User->id);
    }
    
    /**
     * @test
     */
    public function processWithInvalidData()
    {
        $this->_setRequest(array());
        
        $this->dispatch("news/process-edit-form");
        $this->_assertDispatch('news', 'process-edit-form');
        $this->assertContains(Helper::getTranslator()->translate("validation_message-field_empty"), $this->getResponse()->getBody());
        
        $this->assertEquals(0, NewsTable::getInstance()->count());
    }
}
