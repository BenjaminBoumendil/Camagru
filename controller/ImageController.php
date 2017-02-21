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
    * Create thumbnail of $src in $dest
    */
    private function makeThumb($src, $dest, $desiredWidth, $desiredHeight)
    {
        $sourceImage = imagecreatefromjpeg($src);
        $width = imagesx($sourceImage);
        $height = imagesy($sourceImage);

        $virtualImage = imagecreatetruecolor($desiredWidth, $desiredHeight);

        imagecopyresampled($virtualImage, $sourceImage, 0, 0, 0, 0, $desiredWidth, $desiredHeight, $width, $height);

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
