<?php
require_once('/core/Action.class.php');
abstract class ActionController extends Action
{
    public function __construct()
    {
        parent::__construct() ;
    }

    public function index()
    {
        $this->dis('Index/show') ;
    }

}