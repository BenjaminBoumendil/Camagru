<?php

class ImageEntity extends Entity
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
    protected function create($name, $file)
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
    protected function getAllByUser($userID=null)
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
    public function getAll()
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
}

?>
