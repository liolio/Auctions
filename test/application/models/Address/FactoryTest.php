<?php
/**
 * @class Address_FactoryTest
 */
class Address_FactoryTest extends TestCase_Database
{
    
    /**
     * @test
     */
    public function create()
    {
        $data = array(
            FieldIdEnum::ADDRESS_NAME           =>  'name',
            FieldIdEnum::ADDRESS_SURNAME        =>  'surname',
            FieldIdEnum::ADDRESS_STREET         =>  'street 1',
            FieldIdEnum::ADDRESS_POSTAL_CODE    =>  '12-234',
            FieldIdEnum::ADDRESS_CITY           =>  'city',
            FieldIdEnum::ADDRESS_COUNTRY        =>  'country',
            FieldIdEnum::ADDRESS_PHONE_NUMBER   =>  '+48 12 34 56 789',
            FieldIdEnum::ADDRESS_PROVINCE       =>  'province'
        );
        
        $user = UserTable::getInstance()->findOneBy('login', 'admin');
        $address = Address_Factory::create($user, $data);
        
        $this->assertEquals($data[FieldIdEnum::ADDRESS_NAME], $address->name);
        $this->assertEquals($data[FieldIdEnum::ADDRESS_SURNAME], $address->surname);
        $this->assertEquals($data[FieldIdEnum::ADDRESS_STREET], $address->street);
        $this->assertEquals($data[FieldIdEnum::ADDRESS_POSTAL_CODE], $address->postal_code);
        $this->assertEquals($data[FieldIdEnum::ADDRESS_CITY], $address->city);
        $this->assertEquals($data[FieldIdEnum::ADDRESS_COUNTRY], $address->country);
        $this->assertEquals($data[FieldIdEnum::ADDRESS_PHONE_NUMBER], $address->phone_number);
        $this->assertEquals($data[FieldIdEnum::ADDRESS_PROVINCE], $address->province);
        $this->assertEquals($user->id, $address->User->id);
    }
}
