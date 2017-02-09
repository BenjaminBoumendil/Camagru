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

    // $fd = fopen("/home/ben/camagru/log.txt", "x");
    // fclose($fd);

    file_put_contents("/home/ben/camagru/log.txt", $_SERVER, FILE_APPEND);

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
