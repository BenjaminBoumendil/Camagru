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
    * not null, alphanumeric string, no space
    */
    private function argCheck($str)
    {
        if (isset($str) && ctype_alnum($str) && !preg_match('/\s/', $str)) {
            return true;
        } else {
            return false;
        }
    }

    /*
    * Check for email string
    * not null, php email filter
    */
    private function emailCheck($email)
    {
        if (isset($email) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        } else {
            return false;
        }
    }

    /*
    * return one user, author of $imageID
    */
    public function getImageAuthor($imageID)
    {
        $imageController = new ImageController();

        $image = $imageController->getImageAuthor($imageID);
        $user = $this->getOne($image['UserFK']);

        return $user;
    }

    /*
    * Register a user and send a mail
    * return 201 in success or 400
    */
    public function register()
    {
        if ($this->argCheck($_POST['username']) &&
            $this->emailCheck($_POST['email']) &&
            $this->argCheck($_POST['password']))
        {
            if ($this->create($_POST["username"], $_POST["email"], $_POST["password"]))
            {
                mail($_POST["email"], "Welcome",
                    "You are now registered as " . $_POST['username'] .
                    "and your password is " . $_POST['password']
                    );
                return 201;
            }
        }
        return 400;
    }

    /*
    * Login a user and set session variables:
    *   isLogged : boolean for current logged user
    *   UserID : ID for current user
    *   Username : Username for current user
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
    * Logout user, destroy SESSION
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
