<?php
/**
 * @class Form_Element_TextTest
 */
class Form_Element_TextTest extends TestCase_NoDatabase
{
    
    /**
     * @var Form_Element_Text
     */
    private $_element;
    
    protected function setUp()
    {
        $this->_element = new Form_Element_Text('FieldName');
    }
    
    /**
     * @test
     */
    public function constructTest()
    {
        $this->assertEquals('formText', $this->_element->getAttrib('class'));
        $this->assertEquals(
                array('Zend_Filter_StringTrim', 'Zend_Filter_StripTags'), 
                array_keys($this->_element->getFilters())
        );
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
