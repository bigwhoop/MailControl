<?php
namespace MailControl\Example;

// Callback classes.
// Each one has to be in the same namespace.
class TestController
{
    public function startServiceAction(array $services, $force = true)
    {
        var_dump(func_get_args());
    }
}

// Build
require __DIR__ . '/../build/build-phar.php';

// Get mailbox
use MailControl\Mail\Connection;
$mailbox = new Connection('{imap.randstand.ch:993/ssl/novalidate-cert}', 'test@randstand.ch', 'test');

// Setup front controller
use MailControl\Controller\Front as FrontController;
$front = new FrontController();
$front->setMessageCollection($mailbox->getNewMessages())
      ->getDispatcher()->setCallbackNamespace(__NAMESPACE__);

// Rock 'n roll! \m/
$front->run();