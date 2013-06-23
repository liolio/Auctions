<?php
/**
 * @class Auctions_Form_News_AddTest
 */
class Auctions_Form_News_AddTest extends TestCase_Controller
{
    
    /**
     * @var Auctions_Form_News_Add
     */
    private $_form;
    
    protected function setUp()
    {
        parent::setUp();
        
        $this->_form = new Auctions_Form_News_Add();
    }
    
    /**
     * @test
     */
    public function isValidWithValidValues()
    {
        $this->assertTrue($this->_form->isValid(array(
            FieldIdEnum::NEWS_TITLE         =>  'title',
            FieldIdEnum::NEWS_DESCRIPTION   =>  'descr',
        )));
    }
    
    /**
     * @test
     * @dataProvider invalidValuesProvider
     */
    public function isValidWithInvalidValues(array $data, array $errors)
    {
        $this->assertFalse($this->_form->isValid($data));
        
        $this->assertEquals($errors, $this->_form->getErrors());
    }
    
    public function invalidValuesProvider()
    {
        return array(
            //empty
            array(
                array(
                    FieldIdEnum::NEWS_TITLE         =>  '',
                    FieldIdEnum::NEWS_DESCRIPTION   =>  '',
                ),
                array(
                    FieldIdEnum::NEWS_TITLE         =>  array(Zend_Validate_NotEmpty::IS_EMPTY),
                    FieldIdEnum::NEWS_DESCRIPTION   =>  array(Zend_Validate_NotEmpty::IS_EMPTY),
                    ParamIdEnum::FORM_ADD_BUTTON    =>  array()
                )
            ),
            //too long
            array(
                array(
                    FieldIdEnum::NEWS_TITLE         =>  str_repeat('a', 101),
                    FieldIdEnum::NEWS_DESCRIPTION   =>  'a',
                ),
                array(
                    FieldIdEnum::NEWS_TITLE         =>  array(Validate_StringLength::TOO_LONG),
                    FieldIdEnum::NEWS_DESCRIPTION   =>  array(),
                    ParamIdEnum::FORM_ADD_BUTTON    =>  array()
                )
            ),
        );
    }
}
