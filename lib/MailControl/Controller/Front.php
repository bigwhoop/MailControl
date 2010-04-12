<?php
namespace MailControl\Controller;
use MailControl\Mail\Message;

use MailControl\Controller\Dispatcher;
use MailControl\Mail\Message\Collection as MessageCollection;

class Front
{
    /**
     * @var MailControl\Mail\Message\Collection
     */
    protected $_messageCollection = null;
    
    /**
     * @var MailControl\Controller\Dispatcher\Interf4ce
     */
    protected $_dispatcher = null;
    
    
    /**
     * Set the mailbox
     * 
     * @param MailControl\Mail\Message\Collection $collection
     * @return MailControl\Controller\Front
     */
    public function setMessageCollection(MessageCollection $collection)
    {
        $this->_messageCollection = $collection;
        return $this;
    }
    
    
    /**
     * Return the mailbox
     * 
     * @return null|MailControl\Mail\Message\Collection
     */
    public function getMessageCollection()
    {
    	return $this->_messageCollection;
    }
    
    
    /**
     * Set the dispatcher
     * 
     * @param MailControl\Controller\Dispatcher\Interf4ce $dispatcher
     * @return MailControl\Controller\Dispatcher\Standard
     */
    public function setDispatcher(Dispatcher\Interf4ce $dispatcher)
    {
    	$this->_dispatcher = $dispatcher;
    	return $this;
    }
    
    
    /**
     * Return the dispatcher. If none was set previously,
     * the standard dispatcher is returned.
     * 
     * @return MailControl\Controller\Dispatcher\Standard
     */
    public function getDispatcher()
    {
    	if (null === $this->_dispatcher) {
    	    $this->setDispatcher(new Dispatcher\Standard());
    	}
    	
    	return $this->_dispatcher;
    }
    
    
    /**
     * Get all new messages from the mailbox and dispatch each one
     * 
     * @return MailControl\Controller\Dispatcher\Standard
     */
    public function run()
    {
        $dispatcher = $this->getDispatcher();
        
        foreach ($this->getMessageCollection() as $message) {
            $dispatcher->dispatch($message);
        }
        
    	return $this;
    }
}