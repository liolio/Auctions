<?php
/**
 * @class Validate_DateTest
 */
class Validate_DateTest extends TestCase_NoDatabase
{

    /**
     * @test
     */
    public function construct()
    {
        $validator = new Validate_Date();
        
        $this->assertEquals(
            array(
                Validate_Date::INVALID      =>  Helper::getTranslator()->translate('validation_message-date_invalid_type'),
                Validate_Date::INVALID_DATE =>  Helper::getTranslator()->translate('validation_message-date_invalid_date'),
                Validate_Date::FALSEFORMAT  =>  Helper::getTranslator()->translate('validation_message-date_false_format')
            ),
            $validator->getMessageTemplates()
        );
    }
}
