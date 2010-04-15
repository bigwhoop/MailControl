<?php
namespace MailControl\Controller\Dispatcher;
use MailControl\Mail;
use MailControl\Filter;

class Standard extends Abstr4ct
{
    /**
     * @var string
     */
    protected $_callbackNamespace = '';
    
    
    /**
     * Set the namespace of the callback classes.
     * 
     * @param string $namespace
     * @return MailControl\Controller\Dispatcher\Standard
     */
    public function setCallbackNamespace($namespace)
    {
        if (substr($namespace, -1) == '\\') {
            $namespace = substr($namespace, 0, -1);
        }
        
        $this->_callbackNamespace = $namespace;
        
        return $this;
    }
    
    
    /**
     * Return the namespace which is prefixed to all
     * classes on callback.
     * 
     * @return string
     */
    public function getCallbackNamespace()
    {
        return $this->_callbackNamespace;
    }
    
    
    /**
     * Format the class name. Eg. "mail-manager@example.org"
     * to "<CallbackNamspace>\MailManagerController". 
     * 
     * @param string $value
     * @return string
     */
    public function formatClassName($value)
    {
        // We split by a space in case a string like the following
        // is provided: "Philippe Gerber <philippe@bigwhoop.ch>"
        $values = explode(' ', $value);
        
        foreach ($values as $value) {
            if (false === strpos($value, '@')) {
                continue;
            }
            
            // Get the value before the @
            $value = substr($value, 0, strrpos($value, '@'));
            
            // Convert to CamelCase
            $filter = new Filter\String\CamelCase();
            $value  = $filter->filter($value, array('ucfirst' => true));
            
            // Prefix the namespace and suffix 'Controller'
            $value = $this->_callbackNamespace . '\\' . $value . 'Controller';
            
            return $value;
        }
        
        throw new Exception('Failed to extract the controller name from "' . join(' ', $values) . '"');
    }
    
    
    /**
     * Format the method name. Eg. "restart service"
     * to "restartServiceAction". 
     * 
     * @param string $value
     * @return string
     */
    public function formatMethodName($value)
    {
        $filter = new Filter\String\CamelCase();
        $value  = $filter->filter($value);
        
        $value .= 'Action';
        
        return $value;
    }
    
    
    /**
     * Parse the params as INI string. If string is not a
     * valid INI representation, an empty array is returned. 
     * 
     * @param string $value
     * @return array
     */
    public function formatParams($value)
    {
        $values = parse_ini_string($value, true);
        return (array)$values;
    }
    
    
    /**
     * Dispatch a mail message
     * 
     * @param MailControl\Mail\Message $message
     * @return 
     */
    public function dispatch(Mail\Message $message)
    {
        $class  = $this->formatClassName($message->getHeaderValue('to'));
        $method = $this->formatMethodName($message->getHeaderValue('subject'));
        $params = $this->formatParams($message->getBody());
        
        echo $class . '->' . $method . '()' . PHP_EOL;
        /*
        var_dump($params);
        echo PHP_EOL . PHP_EOL;
        */
        
        if (!@class_exists($class, true)) {
            // TODO: Log error
            return $this;
        }
        
        $object = new $class();
        
        if (!method_exists($object, $method)) {
            // TODO: Log error
            return $this;
        }
        
        // Check if we have all required params of the method
        // and sort them in the correct sequence of how they're
        // defined.
        // 
        //  Eg. $params = array(
        //          'action'  => 'restart',
        //          'service' => 'mysql',
        //      );
        //
        //      ServiceManager->addJob($service, $action, $force = true)
        //
        //      $sortedParams = array(
        //          'service' => 'mysql',
        //          'action'  => 'restart',
        //          'force'   => true,
        //      );
        $sortedParams = array();
        $reflection   = new \ReflectionMethod($class, $method);
        
        foreach ($reflection->getParameters() as $param) {
            if (array_key_exists($param->getName(), $params)) {
                $sortedParams[$param->getPosition()] = $param->isArray()
                                                     ? (array)$params[$param->getName()]
                                                     : $params[$param->getName()];
            } elseif ($param->isDefaultValueAvailable()) {
                $sortedParams[$param->getPosition()] = $param->getDefaultValue();
            } else {
                // TODO: Log error
                return $this;
            }
        }
        
        ksort($sortedParams);
        
        // Fire callback
        call_user_func_array(array($object, $method), $sortedParams);
        
        return $this;
    }
}