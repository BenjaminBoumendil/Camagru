<?php

require_once("manager.php");

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
        $this->bddInstance->prepExec("INSERT INTO Image (Name, File)
                                     VALUES (?, ?);",
                                     array($name, $file));
    }

    public function getAllImageByUser()
    {

    }

    public function getAllImage()
    {

    }
}

?>
