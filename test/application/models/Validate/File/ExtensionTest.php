<?php
/**
 * @class Validate_File_ExtensionTest
 */
class Validate_File_ExtensionTest extends TestCase_NoDatabase
{
    
    /**
     * @test
     */
    public function construct()
    {
        $validator = new Validate_File_Extension();
        
        $this->assertEquals(
            array(
                Validate_File_Extension::FALSE_EXTENSION    =>  Helper::getTranslator()->translate('validation_message-file_false_extension'),
                Validate_File_Extension::NOT_FOUND          =>  Helper::getTranslator()->translate('validation_message-file_not_found'),
            ),
            $validator->getMessageTemplates()
        );
    }
}
