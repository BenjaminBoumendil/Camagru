<!DOCTYPE html>
<html>
  <style>
    #main {
        float: left;
        width: 75%;
        border: 10px solid grey;
    }
  </style>

  <div id="main">
    <p>Webcam:</p>

    <br />

    <form method="POST" enctype="multipart/form-data" id="imgForm" style="visibility: hidden;">
      <input type="file" name="file" accept="image/*" /><br />
      <input type="hidden" name='action' value="image">
      <input onclick="imgForm()" type="button" value="Submit">
    </form>


    <video autoplay></video>
  </div>

  <script>
      function imgForm() {
        document.getElementById("imgForm").submit();
        window.location.reload();
      }
  </script>

</html>
