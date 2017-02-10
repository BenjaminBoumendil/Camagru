<?php

require_once("Manager.php");

class ImageManager extends Manager
{
    public function createTable()
    {
        $this->bddInstance->query("CREATE TABLE Image
                                  (
                                  ImageID int           NOT NULL AUTO_INCREMENT,
                                  Name varchar(255)     NOT NULL,
                                  File varchar(255)     NOT NULL,
                                  PRIMARY KEY (ImageID)
                                  )
                                  ");
    }

    public function createImage($name, $file)
    {
        try {
            $this->bddInstance->prepExec("INSERT INTO Image (Name, File)
                                         VALUES (?, ?);",
                                         array($name, $file));
        } catch (Exception $e) {
            echo "Camagru Erreur: " . $e;
        }
    }

    public function getAllImageByUser()
    {

    }

    public function getAllImage()
    {

    }

    public function uploadImage()
    {
        file_put_contents(getcwd() . "../log.txt", $_FILES, FILE_APPEND);
        print_r($_FILES);
        $fd = fopen(getcwd() . "../img/test.txt", "x");
        fclose($fd);
        http_response_code(202);
    }
}

?>
