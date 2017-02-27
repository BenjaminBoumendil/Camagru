<!DOCTYPE html>
<html>

  <head>
    <link rel="stylesheet" type="text/css" href="/css/gallery.css">
  </head>

  <div class="gallery">
    <?php
        $imageController = new ImageController();


        if ($_SERVER['QUERY_STRING']) {
            $gallery = $imageController->gallery();

            echo $imageController->getPagination(count($gallery)) . "<br />";
            echo $gallery[$_SERVER['QUERY_STRING'] - 1];
        } else {
            $gallery = $imageController->gallery(true);

            echo $imageController->getPagination(count($gallery)) . "<br />";
            foreach ($gallery as $img) {
                echo $img;
            }
        }
    ?>
  </div>

  <script>
    function commentForm() {
        document.getElementById("commentForm").submit();
        window.location.reload();
    }

    function likeForm() {
        document.getElementById("likeForm").submit();
        window.location.reload();
    }
  </script>

</html>
