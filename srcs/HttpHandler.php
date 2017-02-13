<?php

class HttpHandler
{
    private $userManager;
    private $imageManager;

    public function __construct()
    {
        $this->userManager = new UserManager();
        $this->imageManager = new ImageManager();
    }

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

    private function site()
    {
        $qs = parse_url($_SERVER['QUERY_STRING']);

        if ($qs['path'] == "logout") {
            $this->userManager->logout();
        } elseif ($qs['path'] == "img-upload") {
            http_response_code($this->imageManager->uploadImage());
        } else {
            include("index.html");
        }
    }

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
