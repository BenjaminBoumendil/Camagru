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

echo "Setup Script" . PHP_EOL . PHP_EOL;

$db = Database::getInstance();

$db->openDB("mysql:host=localhost;charset=utf8;");
echo "DB opened" . PHP_EOL;

$db->createDB();
echo "DB created" . PHP_EOL;

$db->query("USE camagru;");

$db->createTable();
echo "Table created" . PHP_EOL;

$db->closeDB();
echo "DB closed";

?>
