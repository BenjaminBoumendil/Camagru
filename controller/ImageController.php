<?php

class ImageController extends ImageEntity
{
    /*
    * Delete one image
    * return 200 in success otherwise 400
    */
    public function deleteImage()
    {
        if ($this->delete($_SESSION['UserID'], $_POST['imageID'])) {
            return 200;
        } else {
            return 400;
        }
    }

    /*
    * Get image deletion form for $imageID
    * return html form
    */
    public function getDeleteForm($imageID)
    {
        $form = "<div>
                   <form method='POST' id='deleteImageForm'>
                     <input type='hidden' name='imageID' value=" . $imageID . " />
                     <input type='hidden' name='action' value='deleteImage' />
                     <input onclick='deleteImageForm();' type='button' value='Delete' />
                   </form>
                 </div>";
        return $form;
    }

    /*
    * return html for pagination
    */
    public function getPagination($gallerySize)
    {
        $pagination = "<div class='pagination' align='center'>";

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

        foreach ($imgArray as $index => $img) {
            $imgField = "<img src=/img/" . $img['Name'] . " />";
            $imgComment = $commentController->getByImage($img['ImageID']);
            $commentForm = $commentController->getForm($img['ImageID']);
            $likeForm = $likeController->getForm($img['ImageID']);
            $deleteForm = $this->getDeleteForm($img['ImageID']);

            if ($isList == true) {
                array_push($gallery, "<a href='?" . ($index + 1) .
                                     "'><div class='img-div' align='center'>" .
                                     $imgField . $imgComment . "</div></a>");
            } else {
                array_push($gallery, "<div class='img-div' align='center'>" .
                                     $imgField . $imgComment . $commentForm .
                                     $likeForm . $deleteForm . "</div>");
            }
        }

        return $gallery;
    }

    /*
    * Create thumbnail of $src in $dest
    */
    private function makeThumb($src, $dest, $desiredWidth, $desiredHeight)
    {
        $sourceImage = imagecreatefromjpeg($src);
        $width = imagesx($sourceImage);
        $height = imagesy($sourceImage);

        $virtualImage = imagecreatetruecolor($desiredWidth, $desiredHeight);

        imagecopyresampled($virtualImage, $sourceImage, 0, 0, 0, 0,
                           $desiredWidth, $desiredHeight, $width, $height);

        imagejpeg($virtualImage, $dest);
    }

    /*
    * Upload an image, save image in "img" directory
    * return 201 in success otherwise 400
    */
    public function uploadImage()
    {
        $fileName = uniqid('img_') . '.jpeg';
        $target = "/img/" . $fileName;
        $thumbDest = "/img/thumb_" . $fileName;

        if (move_uploaded_file($_FILES["file"]["tmp_name"], $_SERVER["DOCUMENT_ROOT"] . $target)) {
            $this->makeThumb($_SERVER["DOCUMENT_ROOT"] . $target,
                             $_SERVER["DOCUMENT_ROOT"] . $thumbDest, 120, 120);
            $this->create($fileName, $target, $thumbDest);
            return 201;
        }
        return 400;
    }

    public function getImageAuthor($imageID)
    {
        return $this->getOne($imageID);
    }

    /*
    * return html with thumb of last $count image uploaded by $userID
    */
    public function getLastThumb($userID, $count=3)
    {
        $images = $this->getAllByUser($userID);

        for ($i = 0; $i < $count; $i++) {
            if (isset($images[$i])) {
                $html .= "<img src=" . $images[$i]['Thumb'] . " />";
            }
        }
        return $html;
    }
}

?>
