<?php

class ImageController extends ImageEntity
{
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
