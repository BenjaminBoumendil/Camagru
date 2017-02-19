<?php

include("srcs/Database.php");

echo "Unset Script" . PHP_EOL . PHP_EOL;

$db = Database::getInstance();

$db->openDB("mysql:host=localhost;charset=utf8;");
echo "DB opened" . PHP_EOL;

$db->query("DROP DATABASE camagru;");

$db->closeDB();
echo "DB closed" . PHP_EOL;

?>
