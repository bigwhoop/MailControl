<?php
require_once 'PHPUnit/Framework.php';
require_once dirname(__FILE__) . '/../../../lib/MailControl/Loader.php';
MailControl\Loader::register();

class MessageTest extends \PHPUnit_Framework_TestCase
{
    public function testConstructingMessage()
    {
        $connection = new MailControl\Mail\Connection('mailbox', 'username', 'password');
        $message = new MailControl\Mail\Message($connection, 0);
        $this->assertNotNull($message);
    }
}