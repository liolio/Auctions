<?php
/**
 * @class File_FactoryTest
 */
class File_FactoryTest extends TestCase_Controller
{
    
    /**
     * @test
     */
    public function create()
    {
        $data = array(
            FieldIdEnum::FILE_FILENAME          =>  'name',
            FieldIdEnum::FILE_MIME_TYPE         =>  'type',
            FieldIdEnum::FILE_ORIGINAL_FILENAME =>  'original_name',
            FieldIdEnum::FILE_SIZE              =>  '12',
        );
        
        $file = File_Factory::create($data, Auth_User::getInstance()->getUser());
        
        $this->assertEquals($data[FieldIdEnum::FILE_FILENAME], $file->filename);
        $this->assertEquals($data[FieldIdEnum::FILE_MIME_TYPE], $file->mime_type);
        $this->assertEquals($data[FieldIdEnum::FILE_ORIGINAL_FILENAME], $file->original_filename);
        $this->assertEquals($data[FieldIdEnum::FILE_SIZE], $file->size);
        $this->assertEquals(1, $file->user_id);
    }
}
