<?php

abstract class Entity
{
    protected $bddInstance;

    public function __construct() {
        $this->bddInstance = Database::getInstance();
        $this->bddInstance->openDB();
    }

    public function __destruct() {
        $this->bddInstance->closeDB();
    }

    abstract public function createTable();
}

?>
