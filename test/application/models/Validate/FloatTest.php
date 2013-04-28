<?php
/**
 * @class Validate_FloatTest
 */
class Validate_FloatTest extends TestCase_NoDatabase
{

    /**
     * @test
     */
    public function construct()
    {
        $validator = new Validate_Float();
        
        $this->assertEquals(
            array(
                Validate_Float::INVALID     =>  Helper::getTranslator()->translate('validation_message-float_invalid_type'),
                Validate_Float::NOT_FLOAT   =>  Helper::getTranslator()->translate('validation_message-float_not_float'),
            ),
            $validator->getMessageTemplates()
        );
    }
}
