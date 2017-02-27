<?php

class CommentController extends CommentEntity
{
    /*
    * return all comment for one image with html
    */
    public function getByImage($imageID)
    {
        $commentArray = $this->getAllByImage($imageID);

        foreach ($commentArray as $comment) {
            $imgComment .= "<p>" . $comment['Content'] . "</p>";
        }

        return $imgComment;
    }

    /*
    * return form to post comment
    */
    public function getForm($imageID)
    {
        return "<form id='commentForm' method='POST'>
                  <textarea name='comment' cols='30' rows='4'></textarea>
                  <input type='hidden' value=" . $imageID . " name='imageID' />
                  <input type='hidden' value='comment' name='action' /><br/>
                  <input onclick='commentForm();' type='button' value='Comment' />
                </form>
               ";
    }

   /*
    * Upload a comment and send a mail to image author
    * return 201 in success otherwise 400
    */
    public function uploadComment()
    {
        $userController = new UserController();

        if ($this->create($_POST['comment'], $_POST['imageID'], $_SESSION['UserID'])) {
            $imageAuthor = $userController->getImageAuthor($_POST['imageID']);
            mail($imageAuthor["Email"], "Welcome",
                 "User " . $_SESSION['Username'] .
                 "posted a comment on your image."
                );
            return 201;
        }
        return 400;
    }
}

?>
