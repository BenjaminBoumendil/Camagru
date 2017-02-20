<?php

class ImageController extends ImageEntity
{
    /*
    * return html for pagination
    */
    public function getPagination($gallerySize)
    {
        $pagination = "<div class='pagination'>";

        for ($i = 1; $i < $gallerySize + 1; $i++) {
            $pagination .= "<a href='?" . $i . "'>" . $i . "</a>";
        }

        $pagination .= "</div>";

        return $pagination;
    }

    /*
    * return an array of all image and comments in gallery
    * add comment and like form if $isList = true
    */
    public function gallery($isList=false)
    {
        $commentController = new CommentController();
        $likeController = new LikeController();
        $gallery = array();
        $imgArray = $this->getAll();

        foreach ($imgArray as $img) {
            $imgField = "<img src=/img/" . $img['Name'] . " /><br />";
            $imgComment = $commentController->getByImage($img['ImageID']);
            $commentForm = $commentController->getForm($img['ImageID']);
            $likeForm = $likeController->getForm($img['ImageID']);

            if ($isList == true) {
                array_push($gallery, $imgField . $imgComment);
            } else {
                array_push($gallery, $imgField . $imgComment . $commentForm . $likeForm);
            }
        }

        return $gallery;
    }

    /*
    * Upload an image, save image in "img" directory
    * return 201 in success otherwise 400
    */
    public function uploadImage()
    {
        $target = $_SERVER["DOCUMENT_ROOT"] . "/img/" . $_FILES["file"]["name"];
        // $dst_image = getcwd() . "/img/thumb_" . $_FILES["file"]["name"];

        if (move_uploaded_file($_FILES["file"]["tmp_name"], $target)) {
            // imagecopyresized($dst_image, $target, 0, 0, 0, 0,
            //                    280, 280, 720, 720);
            $this->create($_FILES["file"]["name"], $target);
            return 201;
        }
        return 400;
    }
}

?>
