<?php
/**
 * @class Auctions_UserController_ProcessEditFormActionTest
 */
class Auctions_UserController_ProcessEditFormActionTest extends TestCase_Controller
{
    
    /**
     * @test
     */
    public function process()
    {
        $request = array(
            FieldIdEnum::USER_ID        =>  '1',
            FieldIdEnum::USER_ACTIVE    =>  '0',
            FieldIdEnum::USER_EMAIL     =>  'qwe@wp.pl',
            FieldIdEnum::USER_LOGIN     =>  'qwe',
            FieldIdEnum::USER_ROLE      =>  'user',
        );
        
        $this->_setRequest($request);
        
        $this->dispatch("user/process-edit-form");
        $this->_assertDispatch('user', 'process-edit-form');
        
        $this->_assertRedirection("user/show-list");
        
        $users = UserTable::getInstance()->findAll();
        $this->assertEquals(1, count($users));
        
        $user = $users->get(0);
        $this->assertFalse($user->active);
        $this->assertEquals($request[FieldIdEnum::USER_EMAIL], $user->email);
        $this->assertEquals($request[FieldIdEnum::USER_LOGIN], $user->login);
        $this->assertEquals($request[FieldIdEnum::USER_ROLE], $user->role);
    }
    
    /**
     * @test
     */
    public function processWithInvalidData()
    {
        $this->_setRequest(array());
        
        $this->dispatch("user/process-edit-form");
        $this->_assertDispatch('user', 'process-edit-form');
        $this->assertContains(Helper::getTranslator()->translate("validation_message-field_empty"), $this->getResponse()->getBody());
        
        $this->assertEquals(1, UserTable::getInstance()->count());
    }
}
