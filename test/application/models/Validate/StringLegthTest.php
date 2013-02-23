<?php
/**
 * @class Validate_StringLegthTest
 */
class Validate_StringLegthTest extends TestCase_NoDatabase
{

    /**
     * @test
     */
    public function construct()
    {
        $validator = new Validate_StringLength();
        
        $this->assertEquals(
            array(
                Validate_StringLength::INVALID      =>  str_replace('%%types%%', 'string', Helper::getTranslator()->translate('validation_message-invalid_type')),
                Validate_StringLength::TOO_SHORT    =>  Helper::getTranslator()->translate('validation_message-too_short'),
                Validate_StringLength::TOO_LONG     =>  Helper::getTranslator()->translate('validation_message-too_long')
            ),
            $validator->getMessageTemplates()
        );
    }
}
