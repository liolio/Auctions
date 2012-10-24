<?php
/**
 * @class ProcessActionTest
 */
class ProcessActionTest extends TestCase_Controller
{
    
    /**
     * @test
     */
    public function processAction()
    {
        $this->_setRequest(array(
            FieldIdEnum::USER_LOGIN     => 'admin',
            FieldIdEnum::USER_PASSWORD  => 'admin2'
        ));
        
        $this->dispatch('/login/process');
        $this->_assertDispatch('auth', 'process');
        
        Zend_Debug::dump($this->_response->getBody());
        Zend_Debug::dump($this->_response->getHeaders());
    }
}
