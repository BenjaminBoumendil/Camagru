<!DOCTYPE html>
<html>

  <head>
    <link rel="stylesheet" type="text/css" href="/css/side.css">
  </head>

  <div id="side">
    <p style="text-align: center;">Last image uploaded:</p>
    <div id="imageDiv">
      <?php
          $imageController = new ImageController();

          echo $imageController->getLastThumb($_SESSION['UserID']);
      ?>
    </div>
  </div>

</html>
