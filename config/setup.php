<?php

include("srcs/BDD.php");

echo "Setup Script" . PHP_EOL . PHP_EOL;

$bdd = BDD::getInstance();

$bdd->openBDD("mysql:host=localhost;charset=utf8;");
echo "BDD opened" . PHP_EOL;

$bdd->createBDD();
echo "BDD created" . PHP_EOL;

$bdd->query("USE camagru;");

$bdd->createTable();
echo "Table created" . PHP_EOL;

$bdd->closeBDD();
echo "BDD closed" . PHP_EOL;

?>
