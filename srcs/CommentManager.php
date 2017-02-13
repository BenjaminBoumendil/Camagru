<?php

require_once("Manager.php");

class CommentManager extends Manager
{
    public function createTable()
    {
        $this->bddInstance->query("CREATE TABLE Comment
                                  (
                                  CommentID int         NOT NULL AUTO_INCREMENT,
                                  Content varchar(255)  NOT NULL,
                                  ImageFK int,
                                  UserFK int,
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
    public function createComment($comment, $imageID, $userID)
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
}

?>
