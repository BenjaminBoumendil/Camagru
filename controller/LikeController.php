<?php

class LikeController extends LikeEntity
{
    /*
    * return true if like is in database otherwise false
    */
    private function likeExist($imageID)
    {
        return count($this->getOne($imageID, $_SESSION['UserID'])) == 1 ?? false;
    }

    /*
    * Get like form for one image
    * return html form
    */
    public function getForm($imageID)
    {
        if ($this->likeExist($imageID)) {
            $value = 'Unlike';
        } else {
            $value = 'Like';
        }

        $form = "<div>
                   <form method='POST' id='likeForm'>
                     <input type='hidden' name='imageID' value=" . $imageID . " />
                     <input type='hidden' name='action' value='like' />
                     <input onclick='likeForm();' type='button' value=" . $value . " />
                   </form>
                 </div><br />";

        return $form;
    }

    /*
    * Like or unlike an image
    */
    public function like()
    {
        if ($this->likeExist($_POST['imageID'])) {
            if ($this->delete($_POST['imageID'], $_SESSION['UserID'])) {
                return 202;
            } else {
                return 400;
            }
        } else {
            if ($this->create($_POST['imageID'], $_SESSION['UserID'])) {
                return 201;
            } else {
                return 400;
            }
        }
    }
}

?>
