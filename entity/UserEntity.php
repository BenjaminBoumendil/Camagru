<?php

class UserEntity extends Entity
{
    /*
    * Create database table for User entity
    */
    public function createTable()
    {
        $this->bddInstance->query("CREATE TABLE User
                                  (
                                  UserID int                 NOT NULL AUTO_INCREMENT,
                                  Username varchar(255)      NOT NULL UNIQUE,
                                  Email varchar(255)         NOT NULL UNIQUE,
                                  Password varchar(255)      NOT NULL,
                                  PRIMARY KEY(UserID)
                                  );"
                                 );
    }

    /*
    * return all user in success otherwise false
    * Store error in SESSION["BDDError"]
    */
    protected function getAll()
    {
        try {
            return $this->bddInstance->query("SELECT * FROM User;");
        } catch (Exception $e) {
            $_SESSION["BDDError"] = "getAllUser error: " . $e;
            return false;
        }
    }

    /*
    * return one user in format array(array()) or false
    * Store error in SESSION["BDDError"]
    */
    protected function getOne($username, $password)
    {
        try {
            $request = $this->bddInstance
                        ->prepare("SELECT UserID, Username, Email, Password FROM User
                                  WHERE Username = ? AND Password = SHA(?);");
            $this->bddInstance->execute($request, array($username, $password));
            return $request->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            $_SESSION["BDDError"] = "getUser Error: " . $e;
            return false;
        }
    }

    /*
    * Create a user with SQL parameters for SQL INJECTION
    * return true in success otherwise false
    * Store error in SESSION["BDDError"]
    */
    protected function create($username, $email, $password)
    {
        try {
            $this->bddInstance->prepExec("INSERT INTO User (Username, Email, Password)
                                          VALUES (?, ?, SHA(?));",
                                          array($username, $email, $password));
            return true;
        } catch (Exception $e) {
            $_SESSION["BDDError"] = "createUser Error: " . $e;
            return false;
        }
    }
}

?>
