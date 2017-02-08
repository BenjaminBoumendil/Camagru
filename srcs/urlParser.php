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
        } else if ($qs['path'] == "img-upload") {
            print_r($_SERVER);
        }
        return false;
    }
}

?>
