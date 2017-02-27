<?php

class HttpHandler
{
    private $userController;
    private $imageController;
    private $commentController;
    private $likeController;

    public function __construct()
    {
        $this->userController = new UserController();
        $this->imageController = new ImageController();
        $this->commentController = new CommentController();
        $this->likeController = new LikeController();
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
            if (isset($_POST['email'])) {
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

        if ($qs['path'] == "logout") {
            $this->userController->logout();
        } elseif ($_POST['action'] == "image") {
            http_response_code($this->imageController->uploadImage());
        } elseif ($_POST['action'] == "comment") {
            http_response_code($this->commentController->uploadComment());
        } elseif ($_POST['action'] == "like") {
            http_response_code($this->likeController->like());
        } elseif ($_POST['action'] == "deleteImage") {
            http_response_code($this->imageController->deleteImage());
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
