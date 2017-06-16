<?php
require_once('ActionController.class.php');
class IndexController extends ActionController
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
        $this->assign('info',$info);
    }
}