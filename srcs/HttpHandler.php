<?php

class HttpHandler
{
    private $userController;
    private $imageController;
    private $commentController;
    private $likeController;
    private $passwordController;

    public function __construct()
    {
        $this->userController = new UserController();
        $this->imageController = new ImageController();
        $this->commentController = new CommentController();
        $this->likeController = new LikeController();
        $this->passwordController = new PasswordController();
    }

    /*
    * Handle site functionality for register user
    */
    private function siteAsLogged()
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
    * Handle site functionality for anonymous user
    */
    private function siteAsAnonymous()
    {
        $qs = parse_url($_SERVER['QUERY_STRING']);

        if ($_POST['action'] == "register") {
            http_response_code($this->userController->register());
            $this->userController->login();
        } elseif ($_POST['action'] == "login") {
            $this->userController->login();
        } elseif ($this->passwordController->isPasswordResetUrl($qs['path'])) {
            $this->passwordController->getResetForm();
        } else {
            include($_SERVER["DOCUMENT_ROOT"] . "/html/register.php");
        }
    }

    /*
    * Check if User is logged or not
    */
    public function handle()
    {
        if ($this->userController->isLogged() == false) {
            $this->siteAsAnonymous();
        }
        else {
            $this->siteAsLogged();
        }
    }
}

?>
