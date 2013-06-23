<?php
/**
 * @class Auctions_Form_Auction_EditTest
 */
class Auctions_Form_Auction_EditTest extends TestCase_Database
{
    /**
     * @var Auctions_Form_Auction_Edit
     */
    private $_form;
    
    protected function setUp()
    {
        parent::setUp();
        
        $this->_loadFixtures(array(
            "Currency/1",
            "Category/1",
            "Auction/1_category_1_start_2012-05-02"
        ));
        
        $this->_form = new Auctions_Form_Auction_Edit();
    }
    
    /**
     * @test
     */
    public function isValidWithValidValues()
    {
        $this->assertTrue($this->_form->isValid(array(
            FieldIdEnum::AUCTION_ID     =>  '1',
            FieldIdEnum::AUCTION_TITLE  =>  'new title',
            ParamIdEnum::CKEDITOR       =>  'new decription',
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
                    FieldIdEnum::AUCTION_ID     =>  '',
                    FieldIdEnum::AUCTION_TITLE  =>  '',
                    ParamIdEnum::CKEDITOR       =>  '',
                ),
                array(
                    FieldIdEnum::AUCTION_ID         =>  array(Zend_Validate_NotEmpty::IS_EMPTY),
                    FieldIdEnum::AUCTION_TITLE      =>  array(Zend_Validate_NotEmpty::IS_EMPTY),
                    ParamIdEnum::CKEDITOR           =>  array(Zend_Validate_NotEmpty::IS_EMPTY),
                    ParamIdEnum::FORM_EDIT_BUTTON   =>  array()
                )
            ),
            //too long
            array(
                array(
                    FieldIdEnum::AUCTION_ID     =>  '1',
                    FieldIdEnum::AUCTION_TITLE  =>  str_repeat('a', 101),
                    ParamIdEnum::CKEDITOR       =>  'new decription',
                ),
                array(
                    FieldIdEnum::AUCTION_ID         =>  array(),
                    FieldIdEnum::AUCTION_TITLE      =>  array(Validate_StringLength::TOO_LONG),
                    ParamIdEnum::CKEDITOR           =>  array(),
                    ParamIdEnum::FORM_EDIT_BUTTON   =>  array()
                )
            ),
            //invalid format
            array(
                array(
                    FieldIdEnum::AUCTION_ID     =>  'one',
                    FieldIdEnum::AUCTION_TITLE  =>  'new title',
                    ParamIdEnum::CKEDITOR       =>  'new decription',
                ),
                array(
                    FieldIdEnum::AUCTION_ID         =>  array(Validate_Int::NOT_INT),
                    FieldIdEnum::AUCTION_TITLE      =>  array(),
                    ParamIdEnum::CKEDITOR           =>  array(),
                    ParamIdEnum::FORM_EDIT_BUTTON   =>  array()
                )
            ),
        );
    }
}
