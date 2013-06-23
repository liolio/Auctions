<?php
/**
 * @class Auctions_NewsController_ProcessAddFormActionTest
 */
class Auctions_NewsController_ProcessAddFormActionTest extends TestCase_Controller
{
    
    /**
     * @test
     */
    public function process()
    {
        $request = array(
            FieldIdEnum::NEWS_TITLE         =>  'title',
            FieldIdEnum::NEWS_DESCRIPTION   =>  'description',
        );
        
        $this->_setRequest($request);
        
        $this->dispatch("news/process-add-form");
        $this->_assertDispatch('news', 'process-add-form');
        
        $this->_assertRedirection("news/show-list");
        
        $newses = NewsTable::getInstance()->findAll();
        $this->assertEquals(1, count($newses));
        
        $news = $newses->get(0);
        $this->assertEquals($request[FieldIdEnum::NEWS_TITLE], $news->title);
        $this->assertEquals($request[FieldIdEnum::NEWS_DESCRIPTION], $news->description);
        $this->assertEquals(1, $news->User->id);
    }
    
    /**
     * @test
     */
    public function processWithInvalidData()
    {
        $this->_setRequest(array());
        
        $this->dispatch("news/process-add-form");
        $this->_assertDispatch('news', 'process-add-form');
        $this->assertContains(Helper::getTranslator()->translate("validation_message-field_empty"), $this->getResponse()->getBody());
        
        $this->assertEquals(0, NewsTable::getInstance()->count());
    }
}
