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
            echo "Camagru ERREUR: " . $e->getMessage();
            return false;
        }
    }

    public function prepExec($query, $value_arr)
    {
        try {
            $req = $this->bdd->prepare($query);
            $req->execute($value_arr);
            return true;
        } catch(PDOException $e) {
            echo "Camagru ERREUR: " . $e->getMessage();
            return false;
        }
    }

    public function createBDD()
    {
        $this->query("CREATE DATABASE camagru;");
    }

    public function createTable()
    {
        $this->query("CREATE TABLE User
                     (
                     UserID int                 NOT NULL AUTO_INCREMENT,
                     Username varchar(255)      NOT NULL UNIQUE,
                     Email varchar(255)         NOT NULL UNIQUE,
                     Password varchar(255)      NOT NULL,
                     PRIMARY KEY(UserID)
                     );"
                    );
    }

    public function openBDD($db_dsn=null, $db_user=null, $db_password=null)
    {
        try {
            require_once("config/database.php");
            if (!isset($this->bdd)) {
                $this->bdd = new PDO($db_dsn ?? $DB_DSN,
                                     $db_user ?? $DB_USER,
                                     $db_password ?? $DB_PASSWORD);
                $this->bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }
        } catch (Exception $e) {
            die("Camagru Erreur : " . $e->getMessage());
        }
    }

    public function closeBDD()
    {
        $this->bdd = null;
    }
}

?>
