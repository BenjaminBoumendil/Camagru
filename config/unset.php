<?php

function __autoload($class_name) {
    $dir_list = ["/srcs/", "/controller/", "/entity/"];
    foreach ($dir_list as $dir) {
        $file_dir = "." . $dir;
        if (file_exists($file_dir . $class_name . '.php')) {
            require_once($file_dir . $class_name . '.php');
            break ;
        }
    }
}

echo "Unset Script" . PHP_EOL . PHP_EOL;

$db = Database::getInstance();

$db->openDB("mysql:host=localhost;charset=utf8;");
echo "DB opened" . PHP_EOL;

$db->query("DROP DATABASE camagru;");

$db->closeDB();
echo "DB closed";

?>
