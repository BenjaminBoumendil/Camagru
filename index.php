<?php

session_start();

function __autoload($class_name) {
    $dir_list = ["/srcs/", "/controller/", "/entity/"];
    foreach ($dir_list as $dir) {
        $file_dir = $_SERVER["DOCUMENT_ROOT"] . $dir;
        if (file_exists($file_dir . $class_name . '.php')) {
            require_once($file_dir . $class_name . '.php');
            break ;
        }
    }
}

function index()
{
    $httpHandler = new HttpHandler();

    $httpHandler->handle();
}

index();

?>
