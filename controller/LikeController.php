<?php

class LikeController extends LikeEntity
{
    public function getButton($imageID)
    {
        $button = "<input type="submit" name="action" value="Like" />";
        return $button;
    }
}

?>
