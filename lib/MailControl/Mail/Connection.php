<?php
namespace MailControl\Mail;
use MailControl\Mail\Message;

class Connection
{
    /**
     * @var array
     */
    protected $_params = array(
        'mailbox'  => null,
        'username' => null,
        'password' => null
    );
    
    /**
     * @var resource|null
     */
    protected $_connection = null;
    
    
    /**
     * Constuctor
     * 
     * @param string $mailbox
     * @param string $username
     * @param string $password
     */
    public function __construct($mailbox, $username, $password)
    {
        $this->setParam('mailbox', $mailbox)
             ->setParam('username', $username)
             ->setParam('password', $password);
    }
    
    
    /**
     * Set the params
     * 
     * @param array $params
     * @return MailControl\Mail\Connection
     */
    public function setParams(array $params)
    {
        foreach ($params as $key => $value) {
            $this->setParam($key, $value);
        }
        
        return $this;
    }
    
    
    /**
     * Return a specific param
     * 
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function getParam($key, $default = null)
    {
        if (array_key_exists((string)$key, $this->_params)) {
            return $this->_params[(string)$key];
        }
        
        return $default;
    }
    
    
    /**
     * Set a specific param
     * 
     * @param string $key
     * @param mixed $value
     * @return MailControl\Mail\Connection
     */
    public function setParam($key, $value)
    {
        $this->_params[(string)$key] = $value;
        return $this;
    }
    
    
    /**
     * Return the mailbox's relative connection string
     * Eg. {imap.example.org:143}
     * 
     * @return string
     */
    public function getConnectionString()
    {
        return substr($this->getParam('mailbox'), 0, strpos($this->getParam('mailbox'), '}') + 1);
    }
    
    
    /**
     * Connect to a mailbox
     * 
     * @return MailControl\Mail\Connection
     */
    public function connect()
    {
    	if ($this->isConnected()) {
    	    return $this;
    	}
    	
    	$this->_connection = @imap_open(
    	    $this->getParam('mailbox'),
    	    $this->getParam('username'),
    	    $this->getParam('password')
    	);
    	
    	if (!is_resource($this->_connection)) {
    	    throw new Connection\Exception('Connection failed.');
    	}
    	
    	return $this;
    }
    
    
    /**
     * Return the connection
     * 
     * @return null|resouce
     */
    public function getConnection()
    {
    	return $this->_connection;
    }
    
    
    /**
     * Return an array all available mailboxes
     * 
     * @param string $pattern
     * @return array
     */
    public function listOtherConnectiones($pattern = '*')
    {
        $this->connect();
        
        $mailboxes = @imap_list($this->_connection, $this->getConnectionString(), $pattern);
        if (!$mailboxes) {
            throw new Connection\Exception('Failed to list mailboxes');
        }
        
        return $mailboxes;
    }
    
    
    /**
     * Select/change the current mailbox
     * 
     * @param string $mailbox
     * @return MailControl\Mail\Connection
     */
    public function selectConnection($mailbox)
    {
        $this->connect();
        
        if (false === strpos($mailbox, '}')) {
            $mailbox = $this->getConnectionString() . $mailbox;
        }
        
        $success = @imap_reopen($this->_connection, $mailbox);
        if (!$success) {
            throw new Connection\Exception('Failed to change mailbox to "' . $mailbox . '"');
        }
        
        return $this;
    }
    
    
    /**
     * Count all messages in the currently selected mailbox
     * 
     * @return int
     */
    public function countMessages()
    {
        $this->connect();
        return imap_num_msg($this->_connection);
    }
    
    
    /**
     * Count new messages in the currently selected mailbox
     * 
     * @return int
     */
    public function countNewMessages()
    {
        $this->connect();
        return imap_num_recent($this->_connection);
    }
    
    
    /**
     * Return a specific message from the current mailbox
     * 
     * @param int $messageNumber
     * @return MailControl\Mail\Message
     */
    public function getMessage($messageNumber)
    {
        $this->connect();
        
        return new Message($this, $messageNumber);
    }
    
    
    public function getNewMessages()
    {
        $collection = new Message\Collection();
        
    	for ($i = 1; $i <= $this->countMessages(); $i++) {
    	    $collection->addMessage($this->getMessage($i));
    	}
    	
    	return $collection;
    }
    
    
    /**
     * Return whether we're already connected to the server
     * 
     * @return bool
     */
    public function isConnected()
    {
        return null !== $this->_connection;
    }
}