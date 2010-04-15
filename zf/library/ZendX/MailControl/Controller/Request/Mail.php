<?php
class ZendX_MailControl_Controller_Request_Mail extends Zend_Controller_Request_Abstract
{
    public function __construct(Zend_Mail_Message $message)
    {
        $controller = $message->getHeader('to', 'string');
        $controller = $this->formatControllerName($controller);
        $this->setParam($this->getControllerKey(), $controller);
        
        $action = $message->getHeader('subject', 'string');
        $action = $this->formatActionName($action);
        $this->setParam($this->getActionKey(), $action);
        
        $params = $message->getContent();
        $params = $this->formatParams($params);
        foreach ($params as $key => $value) {
            $this->setParam($key, $value);
        }
    }
    
    
    public function formatControllerName($value)
    {
        $values = explode(' ', $value);
        
        foreach ($values as $value) {
            if (false === strpos($value, '@')) {
                continue;
            }
            
            $value = strstr($value, '@', true);
            $value = strtolower($value);
            
            return $value;
        }
        
        return null;
    }
    
    
    public function formatActionName($value)
    {
        $value = Zend_Filter::filterStatic($value, 'Word_SeparatorToDash');
        $value = strtolower($value);
        
        return $value;
    }
    
    
    public function formatParams($value)
    {
        $params = $this->_parseIniString($value);
        if (!$params) {
            return array();
        }
        
        unset($params[$this->getModuleKey()]);
        unset($params[$this->getControllerKey()]);
        unset($params[$this->getActionKey()]);
        
        return $params;
    }
    
    
    protected function _parseIniString($value)
    {
   	    if (function_exists('parse_ini_string')) {
   	        return parse_ini_string($value);
   	    }
   	    
   	    $tmpPath = tempnam(sys_get_temp_dir(), 'ini');
   	    
   	    file_put_contents($tmpPath, $value);
   	    $value = parse_ini_file($tmpPath);
   	    unlink($tmpPath);
   	    
   	    return $value;
    }
}
