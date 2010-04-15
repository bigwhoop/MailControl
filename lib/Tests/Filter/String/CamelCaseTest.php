<?php
namespace MailControl\Filter\String;
require_once 'PHPUnit/Framework.php';
require_once dirname(__FILE__) . '/../../../../lib/MailControl/Loader.php';
\MailControl\Loader::register();

use MailControl\Filter;

class CamelCaseTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Convert a string like "pink floyd rocks!!!" to "pinkFloydRocks".
     * 
     * @param string $value
     * @param array $options
     * @return string
     */
    //public function filter($value, array $options = array())
    public function testFilter()
    {
        $this->markTestIncomplete('This test has not been implemented yet.');
    }
    
}
