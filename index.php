<?php

session_start();

function __autoload($class_name) {
    $dir_list = ["srcs/"];
    foreach ($dir_list as $dir) {
        if (file_exists($dir . $class_name . '.php')) {
            require_once($dir . $class_name . '.php');
            break ;
        }
    }
}

function index()
{
    $httpHandler = new HttpHandler();

    file_put_contents(getcwd() . "/log.txt", $_SERVER, FILE_APPEND);

    $httpHandler->handle();
}

index();

?>
