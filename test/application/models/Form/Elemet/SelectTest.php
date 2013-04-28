<?php
/**
 * @class Form_Element_SelectTest
 */
class Form_Element_SelectTest extends TestCase_NoDatabase
{
    
    /**
     * @var Form_Element_Select
     */
    private $_element;
    
    protected function setUp()
    {
        $this->_element = new Form_Element_Select('FieldName');
    }
    
    /**
     * @test
     */
    public function constructTest()
    {
        $this->assertEquals('formSelect', $this->_element->getAttrib('class'));
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
