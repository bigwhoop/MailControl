<?php
require_once 'PHPUnit/Framework.php';
require_once dirname(__FILE__) . '/../../../MailControl/Loader.php';
MailControl\Loader::register();

class StandardTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Set the namespace of the callback classes.
     * 
     * @param string $namespace
     * @return MailControl\Controller\Dispatcher\Standard
     */
    //public function setCallbackNamespace($namespace)
    
    
    /**
     * Return the namespace which is prefixed to all
     * classes on callback.
     * 
     * @return string
     */
    //public function getCallbackNamespace()
    
    
    /**
     * Format the class name. Eg. "mail-manager@example.org"
     * to "<CallbackNamspace>\MailManagerController". 
     * 
     * @param string $value
     * @return string
     */
    //public function formatClassName($value)
    
    
    /**
     * Format the method name. Eg. "restart service"
     * to "restartServiceAction". 
     * 
     * @param string $value
     * @return string
     */
    //public function formatMethodName($value)
    
    
    /**
     * Parse the params as INI string. If string is not a
     * valid INI representation, an empty array is returned. 
     * 
     * @param string $value
     * @return array
     */
    //public function formatParams($value)
    
    
    /**
     * Dispatch a mail message
     * 
     * @param MailControl\Mail\Message $message
     * @return 
     */
    //public function dispatch(Mail\Message $message)
}