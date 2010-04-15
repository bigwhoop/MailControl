<?php
namespace MailControl\Mail;
use MailControl\Mail;

class Message
{
    const PART_ALL       = '';
    const PART_HEADER    = 0;
    const PART_BODY      = 1;
    const PART_BODY_TEXT = 1.1;
    const PART_BODY_HTML = 1.2;
    
    
    /**
     * @var MailControl\Mail\Connection
     */
    protected $_connection = null;
    
    /**
     * @var int
     */
    protected $_messageNumber = null;
    
    
    public function __construct(Mail\Connection $connection, $messageNumber)
    {
    	$this->_connection    = $connection;
    	$this->_messageNumber = (int)$messageNumber;
    }
    
    
    public function getStructure()
    {
        $structure = @imap_fetchstructure($this->_connection->getConnection(), $this->_messageNumber);
        if (!$structure) {
            throw new Exception('Failed to fetch message structure.');
        }
        
        return $structure;
    }
    
    
    public function getPart($part)
    {
        $structure = $this->getStructure();
        
        switch ($structure->type)
        {
            // Text
            case 0:
                if (in_array($part, array(self::PART_BODY_HTML, self::PART_BODY_TEXT), true)) {
                    $part = self::PART_BODY;
                }
                break;
                
            // Multipart
            case 1:
                if (self::PART_BODY === $part) {
                    $part = self::MESSAGE_PART_BODY_TEXT;
                }
                break;
        }
        
        $message = @imap_fetchbody($this->_connection->getConnection(), $this->_messageNumber, $part);
        
        return trim($message);
    }
    
    
    public function getHeader()
    {
        return $this->getPart(self::PART_HEADER);
    }
    
    
    public function getHeaderValues()
    {
        $header = $this->getHeader();
        
        $lastKey = null;
        $values  = array();
        foreach (explode(PHP_EOL, $header) as $line) {
            $parts = explode(':', $line, 2);
            if (2 == count($parts)) {
                $lastKey = strtolower($parts[0]);
                $value   = trim($parts[1]);
                
                $values[$lastKey] = $value;
            } else {
                $values[$lastKey] .= trim($parts[0]);
            }
        }
        
        return $values;
    }
    
    
    public function getHeaderValue($key, $default = null)
    {
        $values = $this->getHeaderValues();
        $key    = strtolower($key);
        
        if (array_key_exists($key, $values)) {
            return $values[$key];
        }
        
        return $default;
    }
    
    
    public function getBody()
    {
        return $this->getPart(self::PART_BODY);
    }
}