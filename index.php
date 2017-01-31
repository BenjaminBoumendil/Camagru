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
    if (!$userManager->isLogged())
    {
        if (!isset($_POST['username'])) {
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
        $userManager->logout();
    }
}

index();

?>
