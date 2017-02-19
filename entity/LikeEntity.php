<?php

class LikeEntity extends Entity
{
    public function createTable()
    {
        $this->dbInstance->query("CREATE TABLE Like
                                  (
                                  LikeID int            NOT NULL AUTO_INCREMENT,
                                  ImageFK int           NOT NULL,
                                  UserFK int            NOT NULL,
                                  PRIMARY KEY (LikeID),
                                  FOREIGN KEY (ImageFK) REFERENCES Image(ImageID),
                                  FOREIGN KEY (UserFK) REFERENCES User(UserID)
                                  )
                                  ");
    }

    /*
    * Create a Like with SQL param for SQL INJECTION
    * return true in success otherwise false
    * Store error in SESSION["DBError"]
    */
    protected function create($imageID, $userID)
    {
        try {
            $this->dbInstance->prepExec("INSERT INTO Like (ImageFK, UserFK)
                                         VALUES (?, ?);",
                                         array($imageID, $userID));
            return true;
        } catch (Exception $e) {
            $_SESSION['DBError'] = "create Error: " . $e;
            return false;
        }
    }
}

?>
