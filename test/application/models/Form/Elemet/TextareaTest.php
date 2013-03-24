<?php
/**
 * @class Form_Element_TextareaTest
 */
class Form_Element_TextareaTest extends TestCase_NoDatabase
{
    
    /**
     * @var Form_Element_Textarea
     */
    private $_element;
    
    protected function setUp()
    {
        $this->_element = new Form_Element_Textarea('FieldName');
    }
    
    /**
     * @test
     */
    public function constructTest()
    {
        $this->assertEquals(
                array('Zend_Filter_StringTrim', 'Zend_Filter_StripTags'), 
                array_keys($this->_element->getFilters())
        );
        $this->assertEquals('40', $this->_element->getAttrib(Form_Element_Textarea::COLS));
        $this->assertEquals('4', $this->_element->getAttrib(Form_Element_Textarea::ROWS));
    }
    
    /**
     * @test
     */
    public function setRequiredTest()
    {
        $this->assertFalse($this->_element->isRequired());
        $this->assertEquals(0, count($this->_element->getValidators()));
        
        $this->_element->setRequired();
        
        $this->assertTrue($this->_element->isRequired());
        $this->assertEquals(array('Validate_NotEmpty'), array_keys($this->_element->getValidators()));
        
        $this->_element->setRequired(false);
        
        $this->assertFalse($this->_element->isRequired());
        $this->assertEquals(0, count($this->_element->getValidators()));
    }
}
