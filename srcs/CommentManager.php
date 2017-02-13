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
}

?>
