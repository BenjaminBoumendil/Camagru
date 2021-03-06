<?php

class ImageEntity extends Entity
{
    /*
    * Create database table for Image Entity
    */
    public function createTable()
    {
        $this->dbInstance->query("CREATE TABLE IF NOT EXISTS Image
                                  (
                                  ImageID int           NOT NULL AUTO_INCREMENT,
                                  Name varchar(255)     NOT NULL,
                                  File varchar(255)     NOT NULL,
                                  Thumb varchar(255)    NOT NULL,
                                  uploadDate DATETIME   DEFAULT CURRENT_TIMESTAMP,
                                  UserFK int,
                                  PRIMARY KEY (ImageID),
                                  FOREIGN KEY (UserFK) REFERENCES User(UserID) ON DELETE CASCADE
                                  )
                                  ");
    }

    /*
    * delete an image with SQL param for SQL INJECTION
    * return true in success otherwise false
    * Store error in SESSION["DBError"]
    */
    protected function delete($userID, $imageID)
    {
        try {
            $this->dbInstance->prepExec("DELETE FROM Image
                                         WHERE ImageID = ? AND UserFK = ?;",
                                         array($imageID, $userID));
            return true;
        } catch (Exception $e) {
            $_SESSION["DBError"] = "createImage Error: " . $e;
            return false;
        }
    }

    /*
    * Create an image with SQL param for SQL INJECTION
    * return true in success otherwise false
    * Store error in SESSION["DBError"]
    */
    protected function create($name, $file, $thumb)
    {
        try {
            $this->dbInstance->prepExec("INSERT INTO Image (Name, File, Thumb, UserFK)
                                         VALUES (?, ?, ?, ?);",
                                         array($name, $file, $thumb, $_SESSION["UserID"]));
            return true;
        } catch (Exception $e) {
            $_SESSION["DBError"] = "createImage Error: " . $e;
            return false;
        }
    }

    /*
    * return all images from user in success otherwise false
    * if no user given, take current user
    * Store error in SESSION["DBError"]
    */
    protected function getAllByUser($userID=null)
    {
        $userID = $userID ?? $_SESSION['UserID'];

        try {
            $request = $this->dbInstance->prepare("SELECT * FROM Image
                                                    WHERE UserFK = ?
                                                    ORDER BY uploadDate DESC;");
            $this->dbInstance->execute($request, array($userID));
            return $request->fetchAll();
        } catch (Exception $e) {
            $_SESSION["DBError"] = "getAllByUser Error: " . $e;
            return false;
        }
    }

    /*
    * return one image in success otherwise false
    * Store error in SESSION["DBError"]
    */
    protected function getOne($imageID)
    {
        try {
            $request = $this->dbInstance
                            ->prepare("SELECT * FROM Image
                                       WHERE ImageID = ?;");
            $this->dbInstance->execute($request, array($imageID));
            return $request->fetchAll();
        } catch (Exception $e) {
            $_SESSION["DBError"] = "getOne Error: " . $e;
            return false;
        }
    }

    /*
    * return all images in success otherwise false
    * Store error in SESSION["DBError"]
    */
    protected function getAll()
    {
        try {
            return $this->dbInstance
                        ->query("SELECT * FROM Image ORDER BY uploadDate DESC;")
                        ->fetchAll();
        } catch (Exception $e) {
            $_SESSION["DBError"] = "getAllImages Error: " . $e;
            return false;
        }
    }
}

?>
