<?php

require_once("manager.php");

class UserManager extends Manager
{
    public function createTable()
    {
        $this->bddInstance->query("CREATE TABLE User
                                  (
                                  UserID int                 NOT NULL AUTO_INCREMENT,
                                  Username varchar(255)      NOT NULL UNIQUE,
                                  Email varchar(255)         NOT NULL UNIQUE,
                                  Password varchar(255)      NOT NULL,
                                  PRIMARY KEY(UserID)
                                  );"
                                 );
    }

    private function getAllUser()
    {
        return $this->bddInstance->query("SELECT * FROM User;");
    }

    private function getUser($username, $password)
    {
        try {
            return $this->bddInstance
                        ->prepExec("SELECT Username, Email, Password FROM User
                                    WHERE Username = ? AND Password = ?;",
                                    array($username, $password));
        } catch (Exception $e) {
            echo "Camagru Erreur: " . $e;
            return false;
        }
    }

    private function createUser($username, $email, $password)
    {
        try {
            $this->bddInstance->prepExec("INSERT INTO User (Username, Email, Password)
                                          VALUES (?, ?, ?);",
                                          array($username, $email, $password));
        } catch (Exception $e) {
            echo "Camagru Erreur: " . $e;
        }
    }

    private function userExist($username, $password)
    {
        try {
            return $this->bddInstance
                        ->prepExec("SELECT Username, Email, Password FROM User
                                    WHERE Username = ? AND Password = ?;",
                                    array($username, $password));
        } catch (Exception $e) {
            echo "Camagru Erreur: " . $e;
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
        $_SESSION = array();
        session_destroy();
    }

    public function isLogged()
    {
        return $_SESSION['isLogged'] ?? false;
    }
}

?>
