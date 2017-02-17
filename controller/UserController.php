<?php

class UserController extends UserEntity
{
    /*
    * return true if user is in database otherwise false
    */
    private function userExist($username, $password)
    {
        return count($this->getOne($username, $password)) == 1 ?? false;
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
            if ($this->create($_POST["username"], $_POST["email"], $_POST["password"]))
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
    *   Username
    */
    public function login()
    {
        if ($this->userExist($_POST['username'], $_POST['password']))
        {
            $current_user = $this->getOne($_POST['username'], $_POST['password'])[0];
            $_SESSION['isLogged'] = true;
            $_SESSION['UserID'] = $current_user['UserID'];
            $_SESSION['Username'] = $current_user['Username'];
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
