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
                  <textarea name='comment' cols='80' rows='8'></textarea>
                  <input type='hidden' value=" . $imageID . " name='imageID' />
                  <input type='hidden' value='comment' name='action' />
                  <input onclick='commentForm();' type='button' value='Comment' />
                </form>
               ";
    }

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
