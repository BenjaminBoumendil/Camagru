<?php

class LikeController extends LikeEntity
{
    /*
    * Get like form for one image
    * return html form
    */
    public function getForm($imageID)
    {
        $form = "<div>
                   <form method='POST' id='likeForm'>
                     <input type='hidden' name='action' value='like' />
                     <input onclick='likeForm();' type='button' value='Like' />
                   </form>
                 </div><br />";
        return $form;
    }

    /*
    * Like or unlike an image
    */
    public function like()
    {
        echo "LIKE";
        return 205;
    }
}

?>
