<?php

class CommentEntity extends Entity
{
    public function createTable()
    {
        $this->bddInstance->query("CREATE TABLE Comment
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
    * Store error in SESSION["BDDError"]
    */
    protected function create($comment, $imageID, $userID)
    {
        try {
            $this->bddInstance->prepExec("INSERT INTO Comment (Content, ImageFK, UserFK)
                                         VALUES (?, ?, ?);",
                                         array($comment, $imageID, $userID));
            return true;
        } catch (Exception $e) {
            $_SERVER['BDDError'] = "createComment Error: " . $e;
            return false;
        }
    }

    /*
    * return all comments by imageID in success otherwise false
    * Store error in SESSION["BDDError"]
    */
    protected function getAllByImage($imageID)
    {
        try {
            $request = $this->bddInstance->prepare("SELECT * FROM Comment
                                                    WHERE ImageFK = ?;");
            $this->bddInstance->execute($request, array($imageID));
            return $request->fetchAll();
        } catch (Exception $e) {
            $_SERVER['BDDError'] = "createComment Error: " . $e;
            return false;
        }
    }
}

?>
