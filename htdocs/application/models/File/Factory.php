<?php
/**
 * @class File_Factory
 */
class File_Factory
{
    
    /**
     * Creates new File object
     * 
     * @param array $data Array of valid data.
     * @return File
     */
    public static function create(array $data, User $user)
    {
        $currency = new File();
        
        $currency->filename = $data[FieldIdEnum::FILE_FILENAME];
        $currency->mime_type = $data[FieldIdEnum::FILE_MIME_TYPE];
        $currency->original_filename = $data[FieldIdEnum::FILE_ORIGINAL_FILENAME];
        $currency->size = $data[FieldIdEnum::FILE_SIZE];
        $currency->User = $user;
        
        return $currency;
    }
}
