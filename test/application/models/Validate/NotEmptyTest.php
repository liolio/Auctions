<?php
/**
 * @class Validate_NotEmptyTest
 */
class Validate_NotEmptyTest extends TestCase_NoDatabase
{
    
    /**
     * @test
     */
    public function construct()
    {
        $validator = new Validate_NotEmpty();
        
        $this->assertEquals(
            array(
                Validate_NotEmpty::IS_EMPTY =>  Helper::getTranslator()->translate('validation_message-field_empty'),
                Validate_NotEmpty::INVALID  =>  str_replace(
                    '%%types%%',
                    'string, integer, float, boolean, array',
                    Helper::getTranslator()->translate('validation_message-invalid_type')
                )
            ),
            $validator->getMessageTemplates()
        );
    }
}
