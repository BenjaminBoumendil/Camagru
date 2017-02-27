<?php

class PasswordEntity extends Entity
{
    public function createTable()
    {
        // $this->dbInstance->query("CREATE TABLE IF NOT EXISTS UserLikeImage
        //                           (
        //                           LikeID int            NOT NULL AUTO_INCREMENT,
        //                           ImageFK int           NOT NULL,
        //                           UserFK int            NOT NULL,
        //                           PRIMARY KEY (LikeID),
        //                           FOREIGN KEY (ImageFK) REFERENCES Image(ImageID) ON DELETE CASCADE,
        //                           FOREIGN KEY (UserFK) REFERENCES User(UserID) ON DELETE CASCADE
        //                           )
        //                          ;"
        //                         );
    }
}

?>
