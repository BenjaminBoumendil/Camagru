<?php

abstract class Entity
{
    protected $bddInstance;

    public function __construct() {
        $this->bddInstance = BDD::getInstance();
        $this->bddInstance->openBDD();
    }

    abstract public function createTable();
}

?>
