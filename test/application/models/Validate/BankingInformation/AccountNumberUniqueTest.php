<?php
/**
 * @class Validate_BankingInformation_AccountNumberUniqueTest
 */
class Validate_BankingInformation_AccountNumberUniqueTest extends TestCase_Controller
{
    
    /**
     * @var Validate_BankingInformation_AccountNumberUnique
     */
    private $_validator;
    
    protected function setUp()
    {
        parent::setUp();
        $this->_validator = new Validate_BankingInformation_AccountNumberUnique();
    }
    
    /**
     * @test
     * @dataProvider dataProvider
     */
    public function isValid($value, array $context, $expectedResult)
    {
        $this->_loadFixtures(array(
            "Currency/1",
            "User/2",
            "BankingInformation/1_currency_1_user_1",
            "BankingInformation/2_currency_1_user_2"
        ));
        
        $this->assertEquals($expectedResult, $this->_validator->isValid($value, $context));
    }
    
    public function dataProvider()
    {
        return array(
            array('123 432 6456 7657 1', $this->_getContext("polski bank", 1), true),   //different account number
            array('123 432 6456 7657', $this->_getContext("polski bank 2", 1), true),   //different bank name
            array('123 432 6456 7657', $this->_getContext("polski bank", 2), true),     //different currency
            array('987 654 3210 5555', $this->_getContext("polski bank", 1), true),     //banking information exists but for annother user
            array('987 654 3210 5555', $this->_getContext("polski bank", 1, 1), true),  //banking information exists but for annother user, ignoring id 1
            array('123 432 6456 7657', $this->_getContext("polski bank", 1, 1), true),  //ignoring id 1
            
            array('123 432 6456 7657', $this->_getContext("polski bank", 1), false)     //exists
        );
    }
    
    private function _getContext($bankName, $currencyId, $id = null)
    {
        $context = array(
            FieldIdEnum::BANKING_INFORMATION_BANK_NAME      =>  $bankName,
            FieldIdEnum::BANKING_INFORMATION_CURRENCY_ID    =>  $currencyId
        );
        
        if (!is_null($id))
            $context[FieldIdEnum::BANKING_INFORMATION_ID] = $id;
        
        return $context;
    }
    
}
