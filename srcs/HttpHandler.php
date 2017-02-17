<?php

class HttpHandler
{
    private $userController;
    private $imageController;
    private $commentController;

    public function __construct()
    {
        $this->userController = new UserController();
        $this->imageController = new ImageController();
        $this->commentController = new CommentController();
    }

    /*
    * Handle register and logging
    */
    private function registerAndLog()
    {
        if (!isset($_POST['username']) && !isset($_POST['password'])) {
            include($_SERVER["DOCUMENT_ROOT"] . "/html/register.php");
        }
        else
        {
            if ($_POST['action'] == "register") {
                http_response_code($this->userController->register());
            }
            else {
                http_response_code(202);
            }
            $this->userController->login();
        }
    }

    /*
    * Handle site functionality for register user
    */
    private function site()
    {
        $qs = parse_url($_SERVER['QUERY_STRING']);
        print_r($_SESSION['BDDError']);

        if ($qs['path'] == "logout") {
            $this->userController->logout();
        } elseif ($qs['path'] == "img-upload") {
            http_response_code($this->imageController->uploadImage());
        } elseif ($qs['path'] == "comment-upload") {
            http_response_code($this->commentController->uploadComment());
        } else {
            include("index.html");
        }
    }

    /*
    * Check if User is logged or not
    */
    public function handle()
    {
        if ($this->userController->isLogged() == false) {
            $this->registerAndLog();
        }
        else {
            $this->site();
        }
    }
}

?>
