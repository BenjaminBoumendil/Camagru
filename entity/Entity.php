<?php

abstract class Entity
{
    protected $dbInstance;

    public function __construct() {
        $this->dbInstance = Database::getInstance();
        $this->dbInstance->openDB();
    }

    public function __destruct() {
        $this->dbInstance->closeDB();
    }

    abstract public function createTable();
}

?>
