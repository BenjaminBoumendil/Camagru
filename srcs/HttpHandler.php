<?php

class HttpHandler
{
    private $userManager;
    private $imageManager;
    private $commentManager;

    public function __construct()
    {
        $this->userManager = new UserManager();
        $this->imageManager = new ImageManager();
        $this->commentManager = new CommentManager();
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
                http_response_code($this->userManager->register());
            }
            else {
                http_response_code(202);
            }
            $this->userManager->login();
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
            $this->userManager->logout();
        } elseif ($qs['path'] == "img-upload") {
            http_response_code($this->imageManager->uploadImage());
        } elseif ($qs['path'] == "comment-upload") {
            // print_r($_SERVER);
            http_response_code($this->commentManager->uploadComment());
        } else {
            include("index.html");
        }
    }

    /*
    * Check if User is logged or not
    */
    public function handle()
    {
        if ($this->userManager->isLogged() == false) {
            $this->registerAndLog();
        }
        else {
            $this->site();
        }
    }
}

?>
