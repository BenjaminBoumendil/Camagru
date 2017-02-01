<?php

class UserManager
{
    private $bddInstance;

    public function __construct() {
        $this->bddInstance = BDD::getInstance();
        $this->bddInstance->openBDD();
    }

    private function getAllUser()
    {
        return $this->bddInstance->query("SELECT * FROM User;");
    }

    private function getUser($username, $password)
    {
        return $this->bddInstance->query("SELECT Username, Email, Password FROM User
                                         WHERE Username=\"" . $username . "\"
                                         AND Password=\"" . $password . "\";");
    }

    private function createUser($username, $email, $password)
    {
        $this->bddInstance->prepExec("INSERT INTO User (Username, Email, Password)
                                      VALUES (?, ?, ?);",
                                      array($username, $email, $password));
    }

    private function userExist($username, $password)
    {
        if ($this->getUser($username, $password)->rowCount() == 1) {
            return true;
        }
        else {
            return false;
        }
    }

    public function register()
    {
        if (isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password']))
        {
            $this->createUser($_POST["username"], $_POST["email"], $_POST["password"]);
        }
    }

    public function login()
    {
        $_SESSION['username'] = $_POST['username'];
        $_SESSION['isLogged'] = $this->userExist($_POST['username'], $_POST['password']);
    }

    public function logout()
    {
        $_SESSION['isLogged'] = false;
        session_destroy();
    }

    public function isLogged()
    {
        return $_SESSION['isLogged'] ?? false;
    }
}

?>
