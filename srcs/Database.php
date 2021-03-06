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

class Database extends Singleton
{
    private $db = null;

    /*
    * Execute a query, not safe to SQL INJECTION
    * return query result in success otherwise throw an Exception
    */
    public function query($query)
    {
        try {
            $resp = $this->db->query($query);
            return $resp;
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    /*
    * Prepare a query, can accept some driver
    * return prepared query in success otherwise throw an Exception
    */
    public function prepare($query, $driver=array())
    {
        try {
            return $this->db->prepare($query, $driver);
        } catch (PDOException $e) {
            throw new Exception($e);
        }
    }

    /*
    * Execute a prepared query with an array of value, safe to SQL INJECTION
    * return query result in success otherwise throw an Exception
    */
    public function execute($request, $param)
    {
        try {
            return $request->execute($param);
        } catch (PDOException $e) {
            throw new Exception($e);
        }
    }

    /*
    * Prepare and execute a query with an array of value in one time
    * return query result in success otherwise throw an Exception
    */
    public function prepExec($query, $value_arr)
    {
        try {
            $req = $this->db->prepare($query);
            $resp = $req->execute($value_arr);
            return $resp;
        } catch(PDOException $e) {
            throw new Exception($e);
        }
    }

    /*
    * Utils function to create the project database
    */
    public function createDB()
    {
        try {
            $this->query("CREATE DATABASE IF NOT EXISTS camagru;");
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    /*
    * Utils function to create all project table
    */
    public function createTable()
    {
        $managers = [new UserEntity(), new ImageEntity(), new CommentEntity(),
                     new LikeEntity()];

        foreach ($managers as $manager) {
            $manager->createTable();
        }
    }

    /*
    * Open PDO connection to database and save it in bdd class variable
    * Use config/database.php connection info by default
    * set PDO attribute to handle database error
    */
    public function openDB($db_dsn=null, $db_user=null, $db_password=null)
    {
        if ($_SERVER["DOCUMENT_ROOT"] == "") {
            require_once("config/database.php");
        } else {
            require_once($_SERVER["DOCUMENT_ROOT"] . "/config/database.php");
        }

        try {
            if (!isset($this->db)) {
                $this->db = new PDO($db_dsn ?? $DB_DSN,
                                     $db_user ?? $DB_USER,
                                     $db_password ?? $DB_PASSWORD);
                $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }
        } catch (Exception $e) {
            die("Camagru Error : " . $e->getMessage());
        }
    }

    /*
    * Close PDO connection to database
    */
    public function closeDB()
    {
        $this->db = null;
    }
}

?>
