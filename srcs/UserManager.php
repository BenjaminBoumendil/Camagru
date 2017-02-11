<?php

require_once("Manager.php");

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
                        ->prepare("SELECT UserID, Username, Email, Password FROM User
                                  WHERE Username = ? AND Password = ?;");
            $hash_password = password_hash($password, PASSWORD_DEFAULT);
            $this->bddInstance->execute($req, array($username, $hash_password));
            return $req->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            echo "Camagru Erreur: " . $e;
            return false;
        }
    }

    private function createUser($username, $email, $password)
    {
        try {
            $hash_password = password_hash($password, PASSWORD_DEFAULT);
            $this->bddInstance->prepExec("INSERT INTO User (Username, Email, Password)
                                          VALUES (?, ?, ?);",
                                          array($username, $email, $hash_password));
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

    public function getCurrentUser($username, $password)
    {
        return $this->getUser($username, $password);
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
            return 201;
        }
        return 400;
    }

    public function login()
    {
        if ($this->userExist($_POST['username'], $_POST['password']))
        {
            $_SESSION['isLogged'] = true;
            $_SESSION['UserID'] = $this->getCurrentUser($_POST['username'], $_POST['password'])[0]['UserID'];
        }
        else
        {
            $_SESSION['isLogged'] = false;
        }
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
