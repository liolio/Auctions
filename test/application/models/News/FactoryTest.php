<?php
/**
 * @class News_FactoryTest
 */
class News_FactoryTest extends TestCase_Controller
{
    
    /**
     * @test
     */
    public function create()
    {
        $data = array(
            FieldIdEnum::NEWS_DESCRIPTION   =>  'description',
            FieldIdEnum::NEWS_TITLE         =>  'title'
        );
        
        $news = News_Factory::create(Auth_User::getInstance()->getUser(), $data);
        
        $this->assertEquals($data[FieldIdEnum::NEWS_DESCRIPTION], $news->description);
        $this->assertEquals($data[FieldIdEnum::NEWS_TITLE], $news->title);
        $this->assertEquals('1', $news->User->id);
    }
}
