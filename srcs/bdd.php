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
            throw new Exception($e);
        }
    }

    public function prepare($query, $driver=array())
    {
        try {
            return $this->bdd->prepare($query, $driver);
        } catch (PDOException $e) {
            throw new Exception($e);
        }
    }

    public function execute($request, $param)
    {
        try {
            return $request->execute($param);
        } catch (PDOException $e) {
            throw new Exception($e);
        }
    }

    public function prepExec($query, $value_arr)
    {
        try {
            $req = $this->bdd->prepare($query);
            $resp = $req->execute($value_arr);
            return $resp;
        } catch(PDOException $e) {
            throw new Exception($e);
        }
    }

    public function createBDD()
    {
        $this->query("CREATE DATABASE camagru;");
    }

    public function createTable()
    {
        require_once("userManager.php");
        require_once("imageManager.php");
        $managers = [new UserManager(), new ImageManager()];

        foreach ($managers as $manager) {
            $manager->createTable();
        }
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
