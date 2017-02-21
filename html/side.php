<!DOCTYPE html>
<html>
  <style>
    #side {
        float: right;
        width: 25%;
        border: 10px solid grey;
    }
  </style>

  <div id="side">
    <?php
      $imageController = new ImageController();

      echo $imageController->getLastThumb($_SESSION['UserID']);
    ?>
  </div>

</html>
