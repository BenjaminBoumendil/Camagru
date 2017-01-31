<?php

include("srcs/bdd.php");

$bdd = BDD::getInstance();
$bdd->openBDD();
$bdd->createTable();
$bdd->closeBDD();

?>
