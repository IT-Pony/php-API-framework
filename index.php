<?php 
    header('Content-Type:text/html;charset=utf-8');
    //判断网站根目录
    if(str_replace('\\','/',dirname($_SERVER['PHP_SELF'])) == '/'){
        //网站根目录
        $root = 'http://'.$_SERVER['HTTP_HOST'];
    }else{
        //网站根目录
        $root = 'http://'.$_SERVER['HTTP_HOST'].str_replace('\\','/',dirname($_SERVER['PHP_SELF']));
    }
    $file_path = str_replace('\\','/',dirname(__FILE__)).'/';
    //公共库文件
    $lib = $file_path.'lib/';
    //公共模版文件
    $tpl = $file_path.'tpl/html/';
    //应用程序入口
    $app = $file_path.'app/';
    //控制器
    $controller = empty($_GET['app']) ? 'index' : trim($_GET['app']);
    //加载函数库
    @include_once($lib.'function.php');
    //加载配置文件
    @include_once($lib.'config.php');
    //判断是不是文件
    if(!empty($controller)){
        if(!is_file($app.$controller.'.php')) die('4042');
        //引用控制器
        include_once($app.$controller.'.php');
        //判断是不是文件
        if(!is_file($html['html'])) die('4041');
        //解析模版文件
        include_once($html['html']);
    }