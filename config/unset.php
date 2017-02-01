<?php

include("srcs/bdd.php");

echo "Unset Script" . PHP_EOL . PHP_EOL;

$bdd = BDD::getInstance();

$bdd->openBDD("mysql:host=localhost;charset=utf8;");
echo "BDD opened" . PHP_EOL;

$bdd->query("DROP DATABASE camagru;");

$bdd->closeBDD();
echo "BDD closed" . PHP_EOL;

?>
