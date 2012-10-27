<?php
/**
 * @class Form_Element_TextTest
 */
class Form_Element_TextTest extends TestCase_NoDatabase
{
    
    /**
     * @test
     */
    public function constructTest()
    {
        $element = new Form_Element_Text('FieldName');
        $this->assertEquals(
                array('Zend_Filter_StringTrim', 'Zend_Filter_StripTags'), 
                array_keys($element->getFilters())
        );
    }
}
