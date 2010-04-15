<?php
namespace MailControl\Controller\Dispatcher;

interface Interf4ce
{
    public function dispatch(\MailControl\Mail\Message $message);
}