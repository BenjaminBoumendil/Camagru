<?php

session_start();

include("srcs/userManager.php");

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
            return index();
        }
    }
    else
    {
        include("index.html");
        // while ($data = $userManager->getAllUser()->fetch())
        // {
        foreach ($userManager->getAllUser() as $data)
        {
            print_r($data);
        }
        // }
    }
}

index();

?>
