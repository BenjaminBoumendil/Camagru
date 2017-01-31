<?php

include("bdd.php");

class UserManager
{
    private $bddInstance;

    public function __construct() {
        $this->bddInstance = BDD::getInstance();
        $this->bddInstance->openBDD();
    }

    public function getAllUser()
    {
        return $this->bddInstance->query("SELECT * FROM User;");
    }

    private function createUser($username, $email, $password)
    {
        $this->bddInstance->prepExec("INSERT INTO User (Username, Email, Password)
                                      VALUES (?, ?, ?);",
                                      array($username, $email, $password));
    }

    public function register()
    {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        if (!isset($_POST['username']) && !isset($_POST['email']) && !isset($_POST['password']))
        {
            $this->createUser($username, $email, $password);
        }
        else {
            throw new Exception('Invalid Form');
        }
    }

    public function login()
    {
        $_SESSION['username'] = $_POST['username'];
        $_SESSION['password'] = $_POST['password'];
    }

    public function logout()
    {
        session_destroy();
    }

    public function isLogged()
    {
        if ($_SESSION['username'] == "ewq") {
            return true;
        } else {
            return false;
        }
    }
}

?>
