<?php
/**
 * @class FileTest
 */
class FileTest extends TestCase_NoDatabase
{
    
    /**
     * @test
     */
    public function getPath()
    {
        $file = new File();
        $file->filename = 'my_filename';
        
        $this->assertEquals(Zend_Controller_Front::getInstance()->getBaseUrl() . '/../uploads/' . $file->filename ,$file->getPath());
    }
    
}
