<?php
    $action = empty($_GET['action']) ? 'index' : trim($_GET['action']);

    //判断是不是函数
    function_exists($action) == true ? $html = $action() : $html= index();
    //首页
    function index(){
        global $tpl,$url;

        $html =  $tpl.'index.html';

        $data = get_defined_vars();

        return $data;
    }
