<?php
/**
 * @class Api_Allegro_Binding
 */
class Api_Allegro_Binding
{
    
    /**
     * @var SoapClient
     */
    private $_soapClient;
    
    /**
     * @var String
     */
    private $_sessionHandle;
    
    
    public function init()
    {
        echo $this->_getSessionHandle();
    }
    
    /**
     * 
     * @return String
     */
    private function _getSessionHandle()
    {
        if (is_null($this->_sessionHandle))
        {
            $loginResult = $this->_getSoapClient()->__soapCall('doLoginEnc', $this->_getCredentails());
            
            $this->_sessionHandle = $loginResult['session-handle-part'];
        }
        
        return $this->_sessionHandle;
    }
    
    private function _getCredentails()
    {
        $secure = Zend_Registry::getInstance()->get("secure");
        
        return array(
            'user-login'    =>  $secure->api->allegro->login,
            'user-password' =>  $secure->api->allegro->password,
            'country-code'  =>  $secure->api->allegro->country_code,
            'webapi-key'    =>  $secure->api->allegro->webapi_key,
            'local-version' =>  $secure->api->allegro->local_version
        );
    }
    
    /**
     * 
     * @return SoapClient
     */
    private function _getSoapClient()
    {
        if (is_null($this->_soapClient)) 
            $this->_soapClient = new SoapClient("https://webapi.allegro.pl/uploader.php?wsdl");
        
        return $this->_soapClient;
    }
}
