<?php
class IndexModule
{
    public function getM()
    {
        $d = D('BUser')->field('id,name,age')->where('id=9')->select();
        pr($d,D('BUser')->endSql());
    }

    public function index()
    {
        echo 'this is module index ' ;
    }
}