<?php

class Singleton
{
    protected static $instance = null;

    protected function __construct() {
    }

    protected function __clone() {
    }

    public static function getInstance() {
        if (!isset(static::$instance)) {
            static::$instance = new static;
        }
        return static::$instance;
    }
}

class BDD extends Singleton
{
    private $bdd = null;

    public function query($query)
    {
        try {
            $resp = $this->bdd->query($query);
            return $resp;
        } catch (Exception $e) {
            return "Erreur : " . $e->getMessage();
        }
    }

    public function prepExec($query, $value_arr)
    {
        try {
            $req = $this->bdd->prepare($query);
            $req->execute($value_arr);
        } catch(PDOException $e) {
            return "Erreur : " . $e->getMessage();
        }
    }

    public function createTable()
    {
        $this->query("CREATE TABLE User
                     (
                     UserID int                 NOT NULL AUTO_INCREMENT,
                     Username varchar(255)      NOT NULL,
                     Email varchar(255)         NOT NULL,
                     Password varchar(255)      NOT NULL,
                     PRIMARY KEY(UserID)
                     );"
                    );
    }

    public function openBDD()
    {
        try {
            if (!isset($this->bdd)) {
                // TODO fix include problem
                $DB_DSN = "mysql:host=localhost;dbname=test;charset=utf8;";
                $DB_USER = "admin";
                $DB_PASSWORD = "admin";
                // include("../config/database.php");
                $this->bdd = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
                $this->bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }
        } catch (Exception $e) {
            die("Erreur : " . $e->getMessage());
        }
    }

    public function closeBDD()
    {
        $this->bdd = null;
    }
}

?>
