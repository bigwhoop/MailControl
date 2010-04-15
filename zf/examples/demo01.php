<?php
set_include_path(get_include_path() . PATH_SEPARATOR . dirname(__FILE__) . '/../library');

require 'Zend/Loader/Autoloader.php';
$autoloader = Zend_Loader_Autoloader::getInstance();
$autoloader->registerNamespace('ZendX');

$mailbox = new Zend_Mail_Storage_Imap(array(
    'host'     => 'imap.example.org',
    'user'     => 'test@example.org',
    'password' => '...'
));

if ($mailbox->countMessages()) {
    $request = new ZendX_MailControl_Controller_Request_Mail($mailbox->getMessage(3));
    
    $front = Zend_Controller_Front::getInstance();
    $front->setControllerDirectory(dirname(__FILE__) . '/../application/controllers')
          ->setRouter(new ZendX_MailControl_Controller_Router_Null())
          ->throwExceptions(true)
          ->dispatch($request);
}