<?php

class UrlParser
{
    private $url_array = [];

    public function urlParse()
    {
        $userManager = new UserManager();
        $qs = parse_url($_SERVER['QUERY_STRING']);

        if ($qs['path'] == "logout") {
            $userManager->logout();
        } elseif ($qs['path'] == "img-upload") {
            print_r($_SERVER);
        }
    }
}

?>
