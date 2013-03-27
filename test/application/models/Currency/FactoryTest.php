<?php
/**
 * @class Currency_FactoryTest
 */
class Currency_FactoryTest extends TestCase_NoDatabase
{
    
    /**
     * @test
     */
    public function create()
    {
        $data = array(
            FieldIdEnum::CURRENCY_NAME                  =>  'c_name',
        );
        
        $currency = Currency_Factory::create($data);
        
        $this->assertEquals($data[FieldIdEnum::CURRENCY_NAME], $currency->name);
    }
}

