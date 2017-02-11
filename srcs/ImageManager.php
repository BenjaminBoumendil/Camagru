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
                                  UserFK int,
                                  PRIMARY KEY (ImageID),
                                  FOREIGN KEY (UserFK) REFERENCES User(UserID)
                                  )
                                  ");
    }

    public function createImage($name, $file)
    {
        try {
            $this->bddInstance->prepExec("INSERT INTO Image (Name, File, UserFK)
                                         VALUES (?, ?, ?);",
                                         array($name, $file, $_SESSION["UserID"]));
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
        $target = getcwd() . "/img/" . $_FILES["file"]["name"];

        if (move_uploaded_file($_FILES["file"]["tmp_name"], $target)) {
            $this->createImage($_FILES["file"]["name"], $target);
            return 201;
        }
        return 400;
    }
}

?>
