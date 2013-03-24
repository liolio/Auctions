<?php
/**
 * @class Auctions_AddressController_ProcessAddFormActionTest
 */
class Auctions_AddressController_ProcessAddFormActionTest extends TestCase_Controller
{
    
    /**
     * @test
     */
    public function process()
    {
        $request = array(
            FieldIdEnum::ADDRESS_NAME           =>  'name',
            FieldIdEnum::ADDRESS_SURNAME        =>  'sur-name',
            FieldIdEnum::ADDRESS_STREET         =>  'street 1/1',
            FieldIdEnum::ADDRESS_POSTAL_CODE    =>  'postal 123',
            FieldIdEnum::ADDRESS_CITY           =>  'city',
            FieldIdEnum::ADDRESS_PROVINCE       =>  'province',
            FieldIdEnum::ADDRESS_COUNTRY        =>  'country',
            FieldIdEnum::ADDRESS_PHONE_NUMBER   =>  '123456890',
        );
        
        $this->_setRequest($request);
        
        $this->dispatch("address/process-add-form");
        $this->_assertDispatch('address', 'process-add-form');
        
        $this->_assertRedirection("address/show-list");
        
        $addresses = AddressTable::getInstance()->findAll();
        $this->assertEquals(2, count($addresses));
        
        $address = $addresses->get(1);
        $this->assertEquals($request[FieldIdEnum::ADDRESS_NAME], $address->name);
        $this->assertEquals($request[FieldIdEnum::ADDRESS_SURNAME], $address->surname);
        $this->assertEquals($request[FieldIdEnum::ADDRESS_STREET], $address->street);
        $this->assertEquals($request[FieldIdEnum::ADDRESS_POSTAL_CODE], $address->postal_code);
        $this->assertEquals($request[FieldIdEnum::ADDRESS_CITY], $address->city);
        $this->assertEquals($request[FieldIdEnum::ADDRESS_PROVINCE], $address->province);
        $this->assertEquals($request[FieldIdEnum::ADDRESS_COUNTRY], $address->country);
        $this->assertEquals($request[FieldIdEnum::ADDRESS_PHONE_NUMBER], $address->phone_number);
    }
    
    /**
     * @test
     */
    public function processWithInvalidData()
    {
        $this->_setRequest(array());
        
        $this->dispatch("address/process-add-form");
        $this->_assertDispatch('address', 'process-add-form');
        $this->assertContains(Helper::getTranslator()->translate("validation_message-field_empty"), $this->getResponse()->getBody());
        
        $this->assertEquals(1, AddressTable::getInstance()->findAll()->count());
    }
}
