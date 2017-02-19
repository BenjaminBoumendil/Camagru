<?php

include("srcs/Database.php");

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
echo "DB closed" . PHP_EOL;

?>
