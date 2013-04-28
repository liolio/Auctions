<?php
/**
 * @class Form_Elements_AttachmentsTest
 */
class Form_Elements_AttachmentsTest extends TestCase_NoDatabase
{
    
    /**
     * @test
     */
    public function getElements()
    {
        $formElements = new Form_Elements_Attachments();
        $fields = array();
        
        foreach ($formElements->getElements() as $element)
        {
            $name = $element->getName();
            $fields[$name] = array_keys(strstr($name, FieldIdEnum::AUCTION_FILE_ID) === false ?
                $element->getTransferAdapter()->getValidators() :
                $element->getValidators()
            );
            
        }
        
        $expectedFields = array();
        $expectedFields[FieldIdEnum::AUCTION_FILE_ID] = array('Validate_NotEmpty');
        
        for ($i = 1; $i < 6; $i++)
            $expectedFields[ParamIdEnum::FILE . "_" . $i] = array('Zend_Validate_File_Upload', 'Validate_File_Extension');
        
        $this->assertEquals($expectedFields, $fields);
    }
}
