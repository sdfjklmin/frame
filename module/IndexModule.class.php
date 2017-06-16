<?php
class IndexModule
{
    public function getM()
    {
       return D('BUser')->select() ;
    }

    public function index()
    {
        echo 'this is module index ' ;
    }
}