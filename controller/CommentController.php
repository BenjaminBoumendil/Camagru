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
        return "<form onsubmit='refreshGallery();' id='commentForm' method='POST' action='/gallery/?comment-upload'>
                  <textarea name='comment' cols='40' rows='5'></textarea>
                  <input type='hidden' value=" . $imageID . " name='imageID' />
                  <input type='submit' />
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
