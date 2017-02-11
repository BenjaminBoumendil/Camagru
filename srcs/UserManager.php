<?php

require_once("Manager.php");

class UserManager extends Manager
{
    /*
    * Create database tables for User entity
    */
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

    /*
    * return One user in format array(array()) or false
    */
    private function getUser($username, $password)
    {
        try {
            $req = $this->bddInstance
                        ->prepare("SELECT UserID, Username, Email, Password FROM User
                                  WHERE Username = ? AND Password = SHA(?);");
            $this->bddInstance->execute($req, array($username, $password));
            return $req->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            echo "Camagru Erreur: " . $e;
            return false;
        }
    }

    /*
    * Create a user with SQL parameters for SQL INJECTION
    * return true in success otherwise false
    */
    private function createUser($username, $email, $password)
    {
        try {
            $this->bddInstance->prepExec("INSERT INTO User (Username, Email, Password)
                                          VALUES (?, ?, SHA(?));",
                                          array($username, $email, $password));
            return true;
        } catch (Exception $e) {
            echo "Camagru Erreur: " . $e;
            return false;
        }
    }

    /*
    * return true if user is in database otherwise false
    */
    private function userExist($username, $password)
    {
        return count($this->getUser($username, $password)) == 1 ?? false;
    }

    /*
    * Check for username and password string
    * check if not null, if string is alphanumeric, have no space
    */
    private function argCheck($arg)
    {
        if (isset($arg) && ctype_alnum($arg) && !preg_match('/\s/', $arg)) {
            return true;
        } else {
            return false;
        }
    }

    /*
    * Register a user and send a mail
    * return 201 in success or 400
    */
    public function register()
    {
        if ($this->argCheck($_POST['username']) &&
            isset($_POST['email']) && $this->argCheck($_POST['password']))
        {
            if ($this->createUser($_POST["username"], $_POST["email"], $_POST["password"]))
            {
                mail($_POST["email"], "Welcome",
                    "You are now registred as " . $_POST['username'] .
                    "and your password is " . $_POST['password']
                    );
                return 201;
            }
        }
        return 400;
    }

    /*
    * Login a user and set session variables:
    *   isLogged : for easy logged user check
    *   UserID : for easy user data retrieve
    */
    public function login()
    {
        if ($this->userExist($_POST['username'], $_POST['password']))
        {
            $_SESSION['isLogged'] = true;
            $_SESSION['UserID'] = $this->getUser($_POST['username'], $_POST['password'])[0]['UserID'];
        }
        else
        {
            $_SESSION['isLogged'] = false;
        }
    }

    /*
    * Logout user set SESSION to empty array and destroy SESSION
    */
    public function logout()
    {
        $_SESSION = array();
        session_destroy();
    }

    /*
    * return true if user is logged otherwise false
    */
    public function isLogged()
    {
        return $_SESSION['isLogged'] ?? false;
    }
}

?>
