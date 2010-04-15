<?php 
class TestController extends Zend_Controller_Action
{
    public function startServiceAction()
    {
        $this->_forward('this-is-a-test');
    }
    
    public function thisIsATestAction()
    {
        var_dump($this->_getAllParams());
        exit();
    }
}