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
        try {
            return $this->bddInstance->query("SELECT * FROM User;");
        } catch (Exception $e) {
            echo "Camagru Erreur: " . $e;
            return false;
        }
    }

    private function getUser($username, $password)
    {
        try {
            $req = $this->bddInstance
                        ->prepare("SELECT Username, Email, Password FROM User
                                  WHERE Username = ? AND Password = ?;");
            $this->bddInstance->execute($req, array($username, $password));
            return $req->fetchAll(PDO::FETCH_ASSOC);
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
        return count($this->getUser($username, $password)) == 1 ?? false;
    }

    private function argCheck($arg)
    {
        if (isset($arg) && ctype_alnum($arg) && !preg_match('/\s/', $arg)) {
            return true;
        } else {
            return false;
        }
    }

    public function register()
    {
        if ($this->argCheck($_POST['username']) &&
            isset($_POST['email']) && $this->argCheck($_POST['password']))
        {
            $this->createUser($_POST["username"], $_POST["email"], $_POST["password"]);
            mail($_POST["email"], "Welcome",
                "You are now registred as " . $_POST['username'] .
                "and your password is " . $_POST['password']
                );
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
