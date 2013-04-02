<?php
/**
 * @class TestCase_Mail
 */
abstract class TestCase_Mail extends TestCase_Controller
{

    /**
     * @var string
     */
    private $_mailFilePath;
    
    protected function setUp()
    {
        parent::setUp();

        $this->_mailFilePath = realpath(FIXTURE_PATH) . DIRECTORY_SEPARATOR .'file' . DIRECTORY_SEPARATOR . 'mail_test.txt';
        Zend_Mail::setDefaultTransport(new Mail_Transport($this->_mailFilePath));
    }
    
    /**
     * @param array $recipients
     * @param string $from
     * @param string $subject
     * @param string $body
     */
    protected function _assertEmailFile(array $recipients, $from, $subject, $body)
    {
        $fileContent = str_replace("\r", '', file_get_contents($this->_mailFilePath));

        $to = 'To: ';
        foreach ($recipients as $recipient)
            $to .= $recipient . ",\n ";

        $this->assertContains(substr($to, 0, -3), $fileContent);
        $this->assertContains('From: ' . $from, $fileContent);
        $this->assertContains('Subject: =?UTF-8?Q?' . str_replace(" ", "=20", quoted_printable_encode($subject)), $fileContent);
        $this->assertContains(Zend_Mime::encode($body, Zend_Mime::ENCODING_QUOTEDPRINTABLE), $fileContent);
    }
}
