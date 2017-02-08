<?php

session_start();

function __autoload($class_name) {
    $dir_list = ["srcs/"];
    foreach ($dir_list as $dir) {
        if (file_exists($dir . $class_name . '.php')) {
            require_once($dir . $class_name . '.php');
            break ;
        }
    }
}

function index()
{
    $userManager = new UserManager();
    $urlParser = new UrlParser();

    print_r($_SERVER);

    if ($userManager->isLogged() == false)
    {
        if (!isset($_POST['username']) && !isset($_POST['password'])) {
            include("html/register.php");
        }
        else
        {
            if ($_POST['action'] == "register") {
                $userManager->register();
            }
            $userManager->login();
        }
    }
    else
    {
        include("index.html");
        $urlParser->urlParse();
    }
}

index();

?>
