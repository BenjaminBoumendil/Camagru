<?php

class UrlParser
{
    private $url_array = [];

    public function urlParse()
    {
        $userManager = new UserManager();
        $imageManager = new ImageManager();
        $qs = parse_url($_SERVER['QUERY_STRING']);

        if ($qs['path'] == "logout") {
            $userManager->logout();
        } elseif ($qs['path'] == "img-upload") {
            $imageManager->uploadImage();
        }
    }
}

?>
