<?php
/**
 * @class Auctions_Form_User_EditTest
 */
class Auctions_Form_User_EditTest extends TestCase_Database
{
    
    /**
     * @var Auctions_Form_User_Edit
     */
    private $_form;
    
    protected function setUp()
    {
        parent::setUp();
        $this->_form = new Auctions_Form_User_Edit();
    }
    
    /**
     * @test
     */
    public function isValidWithValidValues()
    {
        $this->assertTrue($this->_form->isValid(array(
            FieldIdEnum::USER_ID        =>  '1',
            FieldIdEnum::USER_ACTIVE    =>  '0',
            FieldIdEnum::USER_EMAIL     =>  'qwe@wp.pl',
            FieldIdEnum::USER_LOGIN     =>  'qwe',
            FieldIdEnum::USER_ROLE      =>  'user',
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
                    FieldIdEnum::USER_ID        =>  '',
                    FieldIdEnum::USER_ACTIVE    =>  '',
                    FieldIdEnum::USER_EMAIL     =>  '',
                    FieldIdEnum::USER_LOGIN     =>  '',
                    FieldIdEnum::USER_ROLE      =>  '',
                ),
                array(
                    FieldIdEnum::USER_ID            =>  array(Zend_Validate_NotEmpty::IS_EMPTY),
                    FieldIdEnum::USER_ACTIVE        =>  array(),
                    FieldIdEnum::USER_EMAIL         =>  array(Zend_Validate_NotEmpty::IS_EMPTY),
                    FieldIdEnum::USER_LOGIN         =>  array(Zend_Validate_NotEmpty::IS_EMPTY),
                    FieldIdEnum::USER_ROLE          =>  array(Zend_Validate_NotEmpty::IS_EMPTY),
                    ParamIdEnum::FORM_EDIT_BUTTON   =>  array()
                )
            ),
            //too long
            array(
                array(
                    FieldIdEnum::USER_ID        =>  '1',
                    FieldIdEnum::USER_ACTIVE    =>  '0',
                    FieldIdEnum::USER_EMAIL     =>  str_repeat('a', 101),
                    FieldIdEnum::USER_LOGIN     =>  str_repeat('a', 101),
                    FieldIdEnum::USER_ROLE      =>  'user',
                ),
                array(
                    FieldIdEnum::USER_ID            =>  array(),
                    FieldIdEnum::USER_ACTIVE        =>  array(),
                    FieldIdEnum::USER_EMAIL         =>  array(Validate_StringLength::TOO_LONG),
                    FieldIdEnum::USER_LOGIN         =>  array(Validate_StringLength::TOO_LONG),
                    FieldIdEnum::USER_ROLE          =>  array(),
                    ParamIdEnum::FORM_EDIT_BUTTON   =>  array()
                )
            ),
            //invalid
            array(
                array(
                    FieldIdEnum::USER_ID        =>  'one',
                    FieldIdEnum::USER_ACTIVE    =>  '1',
                    FieldIdEnum::USER_EMAIL     =>  'qwe@email.com',
                    FieldIdEnum::USER_LOGIN     =>  'qwe',
                    FieldIdEnum::USER_ROLE      =>  'invalid',
                ),
                array(
                    FieldIdEnum::USER_ID            =>  array(Zend_Validate_Int::NOT_INT),
                    FieldIdEnum::USER_ACTIVE        =>  array(),
                    FieldIdEnum::USER_EMAIL         =>  array(),
                    FieldIdEnum::USER_LOGIN         =>  array(),
                    FieldIdEnum::USER_ROLE          =>  array(Zend_Validate_InArray::NOT_IN_ARRAY),
                    ParamIdEnum::FORM_EDIT_BUTTON   =>  array()
                )
            )
        );
    }
}
