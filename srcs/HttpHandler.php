<?php

class HttpHandler
{
    private $url_array = [];
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
            include("html/register.php");
        }
        else
        {
            if ($_POST['action'] == "register") {
                http_response_code($this->userManager->register());
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
            $this->imageManager->uploadImage();
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
