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

        $this->createUser($username, $email, $password);
    }

    public function login()
    {
        $_SESSION['login'] = "ewq";
    }

    public function logout()
    {
        session_destroy();
    }

    public function isLogged()
    {
        if ($_SESSION['login'] == "ewq") {
            return true;
        } else {
            return false;
        }
    }
}

?>
