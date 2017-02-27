<?php

class CommentEntity extends Entity
{
    public function createTable()
    {
        $this->dbInstance->query("CREATE TABLE IF NOT EXISTS Comment
                                  (
                                  CommentID int         NOT NULL AUTO_INCREMENT,
                                  Content varchar(255)  NOT NULL,
                                  ImageFK int           NOT NULL,
                                  UserFK int            NOT NULL,
                                  PRIMARY KEY (CommentID),
                                  FOREIGN KEY (ImageFK) REFERENCES Image(ImageID),
                                  FOREIGN KEY (UserFK) REFERENCES User(UserID)
                                  )
                                  ");
    }

    /*
    * Create a comment with SQL param for SQL INJECTION
    * return true in success otherwise false
    * Store error in SESSION["DBError"]
    */
    protected function create($comment, $imageID, $userID)
    {
        try {
            $this->dbInstance->prepExec("INSERT INTO Comment (Content, ImageFK, UserFK)
                                         VALUES (?, ?, ?);",
                                         array($comment, $imageID, $userID));
            return true;
        } catch (Exception $e) {
            $_SESSION['DBError'] = "create Error: " . $e;
            return false;
        }
    }

    /*
    * return all comments by imageID in success otherwise false
    * Store error in SESSION["DBError"]
    */
    protected function getAllByImage($imageID)
    {
        try {
            $request = $this->dbInstance->prepare("SELECT * FROM Comment
                                                    WHERE ImageFK = ?;");
            $this->dbInstance->execute($request, array($imageID));
            return $request->fetchAll();
        } catch (Exception $e) {
            $_SESSION['DBError'] = "getAllByImage Error: " . $e;
            return false;
        }
    }
}

?>
