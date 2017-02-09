<?php

abstract class Manager
{
    protected $bddInstance;

    public function __construct() {
        $this->bddInstance = BDD::getInstance();
        $this->bddInstance->openBDD();
    }

    abstract public function createTable();
}

?>
