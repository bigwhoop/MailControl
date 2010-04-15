<?php
namespace MailControl\Example;

// Callback classes.
// Each one has to be in the same namespace.
class TestController
{
    /**
     * An email to "test@randstand.ch" with a subject like "start
     * service" and a body like "services[] = foobar" will trigger
     * this method.
     * 
     * @param array $services
     * @param bool $force
     */
    public function startServiceAction(array $services, $force = true)
    {
        var_dump(func_get_args());
    }
}

// Build
require __DIR__ . '/../build/build-phar.php';

// Get mailbox
use MailControl\Mail\Connection;
$mailbox = new Connection('{imap.example.org:993/ssl/novalidate-cert}', 'test@example.org', '...');

// Setup front controller
use MailControl\Controller\Front as FrontController;
$front = new FrontController();
$front->setMessageCollection($mailbox->getMessages())
      ->getDispatcher()->setCallbackNamespace(__NAMESPACE__);

// Rock 'n roll! \m/
$front->run();