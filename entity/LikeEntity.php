<?php

class LikeEntity extends Entity
{
    public function createTable()
    {
        $this->dbInstance->query("CREATE TABLE IF NOT EXISTS UserLikeImage
                                  (
                                  LikeID int            NOT NULL AUTO_INCREMENT,
                                  ImageFK int           NOT NULL,
                                  UserFK int            NOT NULL,
                                  PRIMARY KEY (LikeID),
                                  FOREIGN KEY (ImageFK) REFERENCES Image(ImageID),
                                  FOREIGN KEY (UserFK) REFERENCES User(UserID)
                                  )
                                 ;"
                                );
    }

    /*
    * return one like
    * Store error in SESSION["DBError"]
    */
    protected function getOne($imageID, $userID)
    {
        try {
            $request = $this->dbInstance
                        ->prepare("SELECT * FROM UserLikeImage
                                  WHERE ImageFK = ? AND UserFK = ?;");
            $this->dbInstance->execute($request, array($imageID, $userID));
            return $request->fetchAll();
        } catch (Exception $e) {
            $_SESSION["DBError"] = "getOne Error: " . $e;
            return false;
        }
    }

    /*
    * Get all like from one user
    * return like list in success otherwise false
    * Store error in SESSION["DBError"]
    */
    protected function getByUser($userID)
    {
      try {
          $request = $this->dbInstance->prepare("SELECT * FROM UserLikeImage
                                                 WHERE UserFK = ?;");
          $this->dbInstance->execute($request, array($userID));
          return $request->fetchAll();
      } catch (Exception $e) {
          $_SESSION['DBError'] = "getByUser Error: " . $e;
          return false;
      }
    }

    /*
    * Create a Like with SQL param for SQL INJECTION
    * return true in success otherwise false
    * Store error in SESSION["DBError"]
    */
    protected function create($imageID, $userID)
    {
        try {
            $this->dbInstance->prepExec("INSERT INTO UserLikeImage (ImageFK, UserFK)
                                         VALUES (?, ?);",
                                         array($imageID, $userID));
            return true;
        } catch (Exception $e) {
            $_SESSION['DBError'] = "create Error: " . $e;
            return false;
        }
    }

    /*
    * Delete one like
    * return true in success otherwise false
    * Store error in SESSION["DBError"]
    */
    protected function delete($imageID, $userID)
    {
        try {
            $this->dbInstance->prepExec("DELETE FROM UserLikeImage
                                         WHERE ImageFK = ? AND UserFK = ?;",
                                         array($imageID, $userID));
            return true;
        } catch (Exception $e) {
            $_SESSION['DBError'] = "delete Error: " . $e;
            return false;
        }
    }
}

?>
