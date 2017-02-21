<!DOCTYPE html>
<html>
  <style>
    #side {
        float: right;
        width: 25%;
        border: 10px solid grey;
    }
    #imageDiv {
        width: 50%;
        margin: 0 auto;
    }
  </style>

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
