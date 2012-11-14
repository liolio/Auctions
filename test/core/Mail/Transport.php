<?php
/**
 * @class Mail_Transport
 */
class Mail_Transport extends Zend_Mail_Transport_Abstract
{
    
    /**
     * @var string
     */
    private $_mailFilePath;
    
    /**
     * 
     * @param string $mailFilePath
     */
    public function __construct($mailFilePath)
    {
        $this->_mailFilePath = $mailFilePath;
    }
    
    protected function _sendMail()
    {
        $file = fopen($this->_mailFilePath, 'w');

        fwrite($file, $this->header . Zend_Mime::LINEEND . $this->body);
        fclose($file);
    }
}