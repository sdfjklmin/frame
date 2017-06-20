<?php
class IndexController extends Action
{
    public function index()
    {
      module('Index')->index() ;
    }

    public function abc()
    {
        echo 'this is abc' ;
    }
    public function look()
    {
        $this->dis('Test/test');
    }

    public function getM()
    {
        $info = module('Index')->getM();
//        $this->dis('Test/test');

    }
}