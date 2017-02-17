<?php

class CommentController extends CommentEntity
{
   /*
    * Upload a comment
    * return 201 in success otherwise 400
    */
    public function uploadComment()
    {
        if ($this->create($_POST['comment'], $_POST['imageID'], $_SESSION['UserID'])) {
            return 201;
        }
        return 400;
    }
}

?>
