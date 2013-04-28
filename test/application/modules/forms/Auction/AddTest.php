<?php
/**
 * @class Auctions_Form_Auction_AddTest
 */
class Auctions_Form_Auction_AddTest extends TestCase_Database
{
    
    /**
     * @var Auctions_Form_Auction_Add
     */
    private $_form;
    
    protected function setUp()
    {
        parent::setUp();
        
        $this->_loadFixtures(array(
            "DeliveryType/1",
            "DeliveryType/2",
            "DeliveryType/3",
            "DeliveryType/4",
            "Category/1",
            "Category/3_parent_1",
            "Currency/1",
        ));
        
        $this->_form = new Auctions_Form_Auction_Add();
        
        $this->_form->removeElement(ParamIdEnum::FILE . "_1");
        $this->_form->removeElement(ParamIdEnum::FILE . "_2");
        $this->_form->removeElement(ParamIdEnum::FILE . "_3");
        $this->_form->removeElement(ParamIdEnum::FILE . "_4");
        $this->_form->removeElement(ParamIdEnum::FILE . "_5");
        $this->_form->removeElement(FieldIdEnum::AUCTION_FILE_ID);
    }
    
    /**
     * @test
     */
    public function isValidWithValidValues()
    {
        $this->assertTrue($this->_form->isValid(array(
            FieldIdEnum::CATEGORY_ID                            =>  '1',
            FieldIdEnum::AUCTION_TITLE                          =>  'auction title',
            ParamIdEnum::CKEDITOR                               =>  '<b>auction <u>description</u></b>',
            FieldIdEnum::AUCTION_START_TIME                     =>  '2012-05-02 22:22:12',
            FieldIdEnum::AUCTION_DURATION                       =>  Enum_Db_Auction_Duration::DURATION_21,
            FieldIdEnum::AUCTION_NUMBER_OF_ITEMS                =>  '10',
            FieldIdEnum::CURRENCY_ID                            =>  '1',
            ParamIdEnum::AUCTION_TRANSACTION_TYPE_BIDDING       =>  '1',
            ParamIdEnum::AUCTION_TRANSACTION_TYPE_BIDDING_PRICE =>  '99,69',
            ParamIdEnum::AUCTION_TRANSACTION_TYPE_BUY_OUT       =>  '1',
            ParamIdEnum::AUCTION_TRANSACTION_TYPE_BUY_OUT_PRICE =>  '123,32',
            FieldIdEnum::DELIVERY_TYPE_ID . "_3"                =>  '1',
            FieldIdEnum::DELIVERY_PRICE . "_3"                  =>  '30,00',
            FieldIdEnum::DELIVERY_TYPE_ID . "_2"                =>  '1',
            FieldIdEnum::DELIVERY_PRICE . "_2"                  =>  '20,00',
            FieldIdEnum::DELIVERY_TYPE_ID . "_1"                =>  '1',
            FieldIdEnum::DELIVERY_PRICE . "_1"                  =>  '10,00',
            FieldIdEnum::DELIVERY_TYPE_ID . "_4"                =>  '1',
            FieldIdEnum::DELIVERY_PRICE . "_4"                  =>  '40,00'
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
                    FieldIdEnum::CATEGORY_ID                            =>  '',
                    FieldIdEnum::AUCTION_TITLE                          =>  '',
                    ParamIdEnum::CKEDITOR                               =>  '',
                    FieldIdEnum::AUCTION_START_TIME                     =>  '',
                    FieldIdEnum::AUCTION_DURATION                       =>  '',
                    FieldIdEnum::AUCTION_NUMBER_OF_ITEMS                =>  '',
                    FieldIdEnum::CURRENCY_ID                            =>  '',
                    ParamIdEnum::AUCTION_TRANSACTION_TYPE_BIDDING       =>  '1',
                    ParamIdEnum::AUCTION_TRANSACTION_TYPE_BIDDING_PRICE =>  '',
                    ParamIdEnum::AUCTION_TRANSACTION_TYPE_BUY_OUT       =>  '1',
                    ParamIdEnum::AUCTION_TRANSACTION_TYPE_BUY_OUT_PRICE =>  '',
                    FieldIdEnum::DELIVERY_TYPE_ID . "_3"                =>  '1',
                    FieldIdEnum::DELIVERY_PRICE . "_3"                  =>  '',
                    FieldIdEnum::DELIVERY_TYPE_ID . "_2"                =>  '1',
                    FieldIdEnum::DELIVERY_PRICE . "_2"                  =>  '',
                    FieldIdEnum::DELIVERY_TYPE_ID . "_1"                =>  '1',
                    FieldIdEnum::DELIVERY_PRICE . "_1"                  =>  '',
                    FieldIdEnum::DELIVERY_TYPE_ID . "_4"                =>  '1',
                    FieldIdEnum::DELIVERY_PRICE . "_4"                  =>  ''
                ),
                array(
                    FieldIdEnum::CATEGORY_ID                            =>  array(Validate_NotEmpty::IS_EMPTY),
                    FieldIdEnum::AUCTION_TITLE                          =>  array(Validate_NotEmpty::IS_EMPTY),
                    ParamIdEnum::CKEDITOR                               =>  array(Validate_NotEmpty::IS_EMPTY),
                    FieldIdEnum::AUCTION_START_TIME                     =>  array(Validate_NotEmpty::IS_EMPTY),
                    FieldIdEnum::AUCTION_DURATION                       =>  array(Validate_NotEmpty::IS_EMPTY),
                    FieldIdEnum::AUCTION_NUMBER_OF_ITEMS                =>  array(Validate_NotEmpty::IS_EMPTY),
                    FieldIdEnum::CURRENCY_ID                            =>  array(Validate_NotEmpty::IS_EMPTY),
                    ParamIdEnum::AUCTION_TRANSACTION_TYPE_BIDDING       =>  array(),
                    ParamIdEnum::AUCTION_TRANSACTION_TYPE_BIDDING_PRICE =>  array(Validate_NotEmpty::IS_EMPTY),
                    ParamIdEnum::AUCTION_TRANSACTION_TYPE_BUY_OUT       =>  array(),
                    ParamIdEnum::AUCTION_TRANSACTION_TYPE_BUY_OUT_PRICE =>  array(Validate_NotEmpty::IS_EMPTY),
                    FieldIdEnum::DELIVERY_TYPE_ID . "_3"                =>  array(),
                    FieldIdEnum::DELIVERY_PRICE . "_3"                  =>  array(Validate_NotEmpty::IS_EMPTY),
                    FieldIdEnum::DELIVERY_TYPE_ID . "_2"                =>  array(),
                    FieldIdEnum::DELIVERY_PRICE . "_2"                  =>  array(Validate_NotEmpty::IS_EMPTY),
                    FieldIdEnum::DELIVERY_TYPE_ID . "_1"                =>  array(),
                    FieldIdEnum::DELIVERY_PRICE . "_1"                  =>  array(Validate_NotEmpty::IS_EMPTY),
                    FieldIdEnum::DELIVERY_TYPE_ID . "_4"                =>  array(),
                    FieldIdEnum::DELIVERY_PRICE . "_4"                  =>  array(Validate_NotEmpty::IS_EMPTY),
                    ParamIdEnum::FORM_ADD_BUTTON                        =>  array()
                )
            ),
            //too long
            array(
                array(
                    FieldIdEnum::CATEGORY_ID                            =>  '1',
                    FieldIdEnum::AUCTION_TITLE                          =>  str_repeat('a', 101),
                    ParamIdEnum::CKEDITOR                               =>  '<b>auction <u>description</u></b>',
                    FieldIdEnum::AUCTION_START_TIME                     =>  '2012-05-02 22:22:12',
                    FieldIdEnum::AUCTION_DURATION                       =>  Enum_Db_Auction_Duration::DURATION_21,
                    FieldIdEnum::AUCTION_NUMBER_OF_ITEMS                =>  '10',
                    FieldIdEnum::CURRENCY_ID                            =>  '1',
                    ParamIdEnum::AUCTION_TRANSACTION_TYPE_BIDDING       =>  '1',
                    ParamIdEnum::AUCTION_TRANSACTION_TYPE_BIDDING_PRICE =>  '99,69',
                    ParamIdEnum::AUCTION_TRANSACTION_TYPE_BUY_OUT       =>  '1',
                    ParamIdEnum::AUCTION_TRANSACTION_TYPE_BUY_OUT_PRICE =>  '123,32',
                    FieldIdEnum::DELIVERY_TYPE_ID . "_3"                =>  '1',
                    FieldIdEnum::DELIVERY_PRICE . "_3"                  =>  '30,00',
                    FieldIdEnum::DELIVERY_TYPE_ID . "_2"                =>  '1',
                    FieldIdEnum::DELIVERY_PRICE . "_2"                  =>  '20,00',
                    FieldIdEnum::DELIVERY_TYPE_ID . "_1"                =>  '1',
                    FieldIdEnum::DELIVERY_PRICE . "_1"                  =>  '10,00',
                    FieldIdEnum::DELIVERY_TYPE_ID . "_4"                =>  '1',
                    FieldIdEnum::DELIVERY_PRICE . "_4"                  =>  '40,00'
                ),
                array(
                    FieldIdEnum::CATEGORY_ID                            =>  array(),
                    FieldIdEnum::AUCTION_TITLE                          =>  array(Validate_StringLength::TOO_LONG),
                    ParamIdEnum::CKEDITOR                               =>  array(),
                    FieldIdEnum::AUCTION_START_TIME                     =>  array(),
                    FieldIdEnum::AUCTION_DURATION                       =>  array(),
                    FieldIdEnum::AUCTION_NUMBER_OF_ITEMS                =>  array(),
                    FieldIdEnum::CURRENCY_ID                            =>  array(),
                    ParamIdEnum::AUCTION_TRANSACTION_TYPE_BIDDING       =>  array(),
                    ParamIdEnum::AUCTION_TRANSACTION_TYPE_BIDDING_PRICE =>  array(),
                    ParamIdEnum::AUCTION_TRANSACTION_TYPE_BUY_OUT       =>  array(),
                    ParamIdEnum::AUCTION_TRANSACTION_TYPE_BUY_OUT_PRICE =>  array(),
                    FieldIdEnum::DELIVERY_TYPE_ID . "_3"                =>  array(),
                    FieldIdEnum::DELIVERY_PRICE . "_3"                  =>  array(),
                    FieldIdEnum::DELIVERY_TYPE_ID . "_2"                =>  array(),
                    FieldIdEnum::DELIVERY_PRICE . "_2"                  =>  array(),
                    FieldIdEnum::DELIVERY_TYPE_ID . "_1"                =>  array(),
                    FieldIdEnum::DELIVERY_PRICE . "_1"                  =>  array(),
                    FieldIdEnum::DELIVERY_TYPE_ID . "_4"                =>  array(),
                    FieldIdEnum::DELIVERY_PRICE . "_4"                  =>  array(),
                    ParamIdEnum::FORM_ADD_BUTTON                        =>  array()
                )
            ),
            //invalid format
            array(
                array(
                    FieldIdEnum::CATEGORY_ID                            =>  '-1',
                    FieldIdEnum::AUCTION_TITLE                          =>  'auction title',
                    ParamIdEnum::CKEDITOR                               =>  '<b>auction <u>description</u></b>',
                    FieldIdEnum::AUCTION_START_TIME                     =>  'invalid',
                    FieldIdEnum::AUCTION_DURATION                       =>  '-1',
                    FieldIdEnum::AUCTION_NUMBER_OF_ITEMS                =>  'ten',
                    FieldIdEnum::CURRENCY_ID                            =>  '-1',
                    ParamIdEnum::AUCTION_TRANSACTION_TYPE_BIDDING       =>  '1',
                    ParamIdEnum::AUCTION_TRANSACTION_TYPE_BIDDING_PRICE =>  'invalid',
                    ParamIdEnum::AUCTION_TRANSACTION_TYPE_BUY_OUT       =>  '1',
                    ParamIdEnum::AUCTION_TRANSACTION_TYPE_BUY_OUT_PRICE =>  'invalid',
                    FieldIdEnum::DELIVERY_TYPE_ID . "_3"                =>  '1',
                    FieldIdEnum::DELIVERY_PRICE . "_3"                  =>  'invalid',
                    FieldIdEnum::DELIVERY_TYPE_ID . "_2"                =>  '1',
                    FieldIdEnum::DELIVERY_PRICE . "_2"                  =>  'invalid',
                    FieldIdEnum::DELIVERY_TYPE_ID . "_1"                =>  '1',
                    FieldIdEnum::DELIVERY_PRICE . "_1"                  =>  'invalid',
                    FieldIdEnum::DELIVERY_TYPE_ID . "_4"                =>  '1',
                    FieldIdEnum::DELIVERY_PRICE . "_4"                  =>  'invalid'
                ),
                array(
                    FieldIdEnum::CATEGORY_ID                            =>  array(Zend_Validate_InArray::NOT_IN_ARRAY),
                    FieldIdEnum::AUCTION_TITLE                          =>  array(),
                    ParamIdEnum::CKEDITOR                               =>  array(),
                    FieldIdEnum::AUCTION_START_TIME                     =>  array(Validate_Date::FALSEFORMAT),
                    FieldIdEnum::AUCTION_DURATION                       =>  array(Zend_Validate_InArray::NOT_IN_ARRAY),
                    FieldIdEnum::AUCTION_NUMBER_OF_ITEMS                =>  array(Validate_Int::NOT_INT),
                    FieldIdEnum::CURRENCY_ID                            =>  array(Zend_Validate_InArray::NOT_IN_ARRAY),
                    ParamIdEnum::AUCTION_TRANSACTION_TYPE_BIDDING       =>  array(),
                    ParamIdEnum::AUCTION_TRANSACTION_TYPE_BIDDING_PRICE =>  array(Validate_Float::NOT_FLOAT),
                    ParamIdEnum::AUCTION_TRANSACTION_TYPE_BUY_OUT       =>  array(),
                    ParamIdEnum::AUCTION_TRANSACTION_TYPE_BUY_OUT_PRICE =>  array(Validate_Float::NOT_FLOAT),
                    FieldIdEnum::DELIVERY_TYPE_ID . "_3"                =>  array(),
                    FieldIdEnum::DELIVERY_PRICE . "_3"                  =>  array(Validate_Float::NOT_FLOAT),
                    FieldIdEnum::DELIVERY_TYPE_ID . "_2"                =>  array(),
                    FieldIdEnum::DELIVERY_PRICE . "_2"                  =>  array(Validate_Float::NOT_FLOAT),
                    FieldIdEnum::DELIVERY_TYPE_ID . "_1"                =>  array(),
                    FieldIdEnum::DELIVERY_PRICE . "_1"                  =>  array(Validate_Float::NOT_FLOAT),
                    FieldIdEnum::DELIVERY_TYPE_ID . "_4"                =>  array(),
                    FieldIdEnum::DELIVERY_PRICE . "_4"                  =>  array(Validate_Float::NOT_FLOAT),
                    ParamIdEnum::FORM_ADD_BUTTON                        =>  array()
                )
            )
        );
    }
}
