<?php

require_once("Manager.php");

class ImageManager extends Manager
{
    /*
    * Create database table for Image Entity
    */
    public function createTable()
    {
        $this->bddInstance->query("CREATE TABLE Image
                                  (
                                  ImageID int           NOT NULL AUTO_INCREMENT,
                                  Name varchar(255)     NOT NULL,
                                  File varchar(255)     NOT NULL,
                                  uploadDate DATETIME   DEFAULT CURRENT_TIMESTAMP,
                                  UserFK int,
                                  PRIMARY KEY (ImageID),
                                  FOREIGN KEY (UserFK) REFERENCES User(UserID)
                                  )
                                  ");
    }

    /*
    * Create an image with SQL param for SQL INJECTION
    * return true in success otherwise false
    * Store error in SESSION["BDDError"]
    */
    public function createImage($name, $file)
    {
        try {
            $this->bddInstance->prepExec("INSERT INTO Image (Name, File, UserFK)
                                         VALUES (?, ?, ?);",
                                         array($name, $file, $_SESSION["UserID"]));
            return true;
        } catch (Exception $e) {
            $_SESSION["BDDError"] = "createImage Error: " . $e;
            return false;
        }
    }

    /*
    * return all images from user in success otherwise false
    * if no user given, take current user
    * Store error in SESSION["BDDError"]
    */
    public function getAllImagesByUser($userID=null)
    {
        $userID = $userID ?? $_SESSION['UserID'];

        try {
            $request = $this->bddInstance->prepare("SELECT * FROM Image
                                                    WHERE UserFK = ?;");
            $this->bddInstance->execute($request, array($userID));
            return $request->fetchAll();
        } catch (Exception $e) {
            $_SESSION["BDDError"] = "getAllImagesByUser Error: " . $e;
            return false;
        }
    }

    /*
    * return all images in success otherwise false
    * Store error in SESSION["BDDError"]
    */
    public function getAllImages()
    {
        try {
            return $this->bddInstance
                        ->query("SELECT * FROM Image ORDER BY uploadDate DESC;")
                        ->fetchAll();
        } catch (Exception $e) {
            $_SESSION["BDDError"] = "getAllImages Error: " . $e;
            return false;
        }
    }

    /*
    * Upload an image, save image in "img" directory
    * return 201 in success otherwise 400
    */
    public function uploadImage()
    {
        $target = getcwd() . "/img/" . $_FILES["file"]["name"];
        // $dst_image = getcwd() . "/img/thumb_" . $_FILES["file"]["name"];

        if (move_uploaded_file($_FILES["file"]["tmp_name"], $target)) {
            // imagecopyresized($dst_image, $target, 0, 0, 0, 0,
            //                    280, 280, 720, 720);
            $this->createImage($_FILES["file"]["name"], $target);
            return 201;
        }
        return 400;
    }
}

?>
