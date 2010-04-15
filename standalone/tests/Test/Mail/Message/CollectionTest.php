<?php
namespace MailControl\Mail\Message;
require_once 'PHPUnit/Framework.php';
require_once dirname(__FILE__) . '/../../../MailControl/Loader.php';
\MailControl\Loader::register();

use MailControl\Mail\Message;

class CollectionTest extends \PHPUnit_Framework_TestCase
{
    public function testSomething()
    {
        $this->markTestIncomplete('This test has not been implemented yet.');
    }
    /**
     * Add a message to the collection
     * 
     * @param MailControl\Mail\Message $message
     * @return MailControl\Mail\Message\Collection
     */
    // public function addMessage(Message $message)
    
}