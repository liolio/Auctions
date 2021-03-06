<?php
/**
 * @class Form_Element_RadioTest
 */
class Form_Element_RadioTest extends TestCase_NoDatabase
{
    
    /**
     * @var Form_Element_Radio
     */
    private $_element;
    
    protected function setUp()
    {
        $this->_element = new Form_Element_Radio('FieldName');
    }
    
    /**
     * @test
     */
    public function constructTest()
    {
        $this->assertEquals('formRadio', $this->_element->getAttrib('class'));
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
