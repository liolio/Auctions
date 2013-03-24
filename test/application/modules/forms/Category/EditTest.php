<?php
/**
 * @class Auctions_Form_Category_EditTest
 */
class Auctions_Form_Category_EditTest extends TestCase_Database
{
    
    /**
     * @var Auctions_Form_Category_Edit
     */
    private $_form;
    
    protected function setUp()
    {
        parent::setUp();
        Fixture_Loader::create("Category/1");
        Fixture_Loader::create("Category/2");
        $this->_form = new Auctions_Form_Category_Edit(array(ParamIdEnum::CATEGORY_WITHOUT_CATEGORY_ID  =>  '2'));
    }
    
    /**
     * @test
     */
    public function isValidWithValidValues()
    {
        $this->assertTrue($this->_form->isValid(array(
            FieldIdEnum::CATEGORY_ID                    =>  '1',
            FieldIdEnum::CATEGORY_NAME                  =>  'name',
            FieldIdEnum::CATEGORY_DESCRIPTION           =>  'description',
            FieldIdEnum::CATEGORY_PARENT_CATEGORY_ID    =>  ParamIdEnum::CATEGORY_MAIN_CATEGORY_PARENT_ID,
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
                    FieldIdEnum::CATEGORY_ID                    =>  '',
                    FieldIdEnum::CATEGORY_NAME                  =>  '',
                    FieldIdEnum::CATEGORY_DESCRIPTION           =>  '',
                    FieldIdEnum::CATEGORY_PARENT_CATEGORY_ID    =>  '',
                ),
                array(
                    FieldIdEnum::CATEGORY_ID                    =>  array(Zend_Validate_NotEmpty::IS_EMPTY),
                    FieldIdEnum::CATEGORY_NAME                  =>  array(Zend_Validate_NotEmpty::IS_EMPTY),
                    FieldIdEnum::CATEGORY_DESCRIPTION           =>  array(Zend_Validate_NotEmpty::IS_EMPTY),
                    FieldIdEnum::CATEGORY_PARENT_CATEGORY_ID    =>  array(Zend_Validate_NotEmpty::IS_EMPTY),
                    ParamIdEnum::SUBMIT_BUTTON                  =>  array()
                )
            ),
            //too long
            array(
                array(
                    FieldIdEnum::CATEGORY_ID                    =>  '1',
                    FieldIdEnum::CATEGORY_NAME                  =>  str_repeat('a', 101),
                    FieldIdEnum::CATEGORY_DESCRIPTION           =>  str_repeat('a', 256),
                    FieldIdEnum::CATEGORY_PARENT_CATEGORY_ID    =>  '1',
                ),
                array(
                    FieldIdEnum::CATEGORY_ID                    =>  array(),
                    FieldIdEnum::CATEGORY_NAME                  =>  array(Zend_Validate_StringLength::TOO_LONG),
                    FieldIdEnum::CATEGORY_DESCRIPTION           =>  array(Zend_Validate_StringLength::TOO_LONG),
                    FieldIdEnum::CATEGORY_PARENT_CATEGORY_ID    =>  array(),
                    ParamIdEnum::SUBMIT_BUTTON                  =>  array()
                )
            ),
            //invalid
            array(
                array(
                    FieldIdEnum::CATEGORY_ID                    =>  'one',
                    FieldIdEnum::CATEGORY_NAME                  =>  'qwe',
                    FieldIdEnum::CATEGORY_DESCRIPTION           =>  'qwe',
                    FieldIdEnum::CATEGORY_PARENT_CATEGORY_ID    =>  '-1',
                ),
                array(
                    FieldIdEnum::CATEGORY_ID                    =>  array(Zend_Validate_Int::NOT_INT),
                    FieldIdEnum::CATEGORY_NAME                  =>  array(),
                    FieldIdEnum::CATEGORY_DESCRIPTION           =>  array(),
                    FieldIdEnum::CATEGORY_PARENT_CATEGORY_ID    =>  array(Zend_Validate_InArray::NOT_IN_ARRAY),
                    ParamIdEnum::SUBMIT_BUTTON                  =>  array()
                )
            )
        );
    }
}
