<?php
namespace MailControl\Mail\Message;
use MailControl\Mail\Message;

class Collection implements \Iterator
{
    protected $_messages = array();
    
    
    /**
     * Add a message to the collection
     * 
     * @param MailControl\Mail\Message $message
     * @return MailControl\Mail\Message\Collection
     */
    public function addMessage(Message $message)
    {
        $this->_messages[spl_object_hash($message)] = $message;
        return $this;
    }
    
    
    public function current()
    {
        return current($this->_messages);
    }
    
    
    public function key()
    {
        return key($this->_messages);
    }
    
    
    public function next()
    {
    	next($this->_messages);
    }
    
    
    public function rewind()
    {
        reset($this->_messages);
    }
    
    
    public function valid()
    {
        return false !== $this->current();
    }
}