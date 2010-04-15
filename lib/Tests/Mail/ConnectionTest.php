<?php
namespace MailControl\Mail;
require_once 'PHPUnit/Framework.php';
require_once dirname(__FILE__) . '/../../../lib/MailControl/Loader.php';
\MailControl\Loader::register();

use MailControl\Mail;

class ConnectionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Constuctor
     * 
     * @param string $mailbox
     * @param string $username
     * @param string $password
     */
    //public function __construct($mailbox, $username, $password)
    
    
    /**
     * Set the params
     * 
     * @param array $params
     * @return MailControl\Mail\Connection
     */
    //public function setParams(array $params)
    
    
    /**
     * Return a specific param
     * 
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    //public function getParam($key, $default = null)
    
    
    /**
     * Set a specific param
     * 
     * @param string $key
     * @param mixed $value
     * @return MailControl\Mail\Connection
     */
    //public function setParam($key, $value)
    
    
    /**
     * Return the mailbox's relative connection string
     * Eg. {imap.example.org:143}
     * 
     * @return string
     */
    //public function getConnectionString()
    
    /**
     * Connect to a mailbox
     * 
     * @return MailControl\Mail\Connection
     */
    //public function connect()
    
    
    /**
     * Return the connection
     * 
     * @return null|resouce
     */
    //public function getConnection()
    
    
    /**
     * Return an array all available mailboxes
     * 
     * @param string $pattern
     * @return array
     */
    //public function listOtherMailboxes($pattern = '*')
    
    
    /**
     * Select/change the current mailbox
     * 
     * @param string $mailbox
     * @return MailControl\Mail\Connection
     */
    //public function selectMailbox($mailbox)
    
    
    /**
     * Count all messages in the currently selected mailbox
     * 
     * @return int
     */
    // public function countMessages()
    
    
    /**
     * Count new messages in the currently selected mailbox
     * 
     * @return int
     */
    // public function countNewMessages()
    
    
    /**
     * Return a specific message from the current mailbox
     * 
     * @param int $messageNumber
     * @return MailControl\Mail\Message
     */
    // public function getMessage($messageNumber)
    
    
    // public function getMessages()
    
    
    /**
     * Return whether we're already connected to the server
     * 
     * @return bool
     */
    //public function isConnected()
}