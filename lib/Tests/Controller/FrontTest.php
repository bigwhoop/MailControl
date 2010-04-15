<?php
require_once 'PHPUnit/Framework.php';
require_once dirname(__FILE__) . '/../../MailControl/Loader.php';

MailControl\Loader::register();
class FrontTest extends \PHPUnit_Framework_TestCase
{
    public function testSomething()
    {
        $this->markTestIncomplete('This test has not been implemented yet.');
    }
}
