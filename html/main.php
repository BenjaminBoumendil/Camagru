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

    <form method="POST" enctype="multipart/form-data" action="/?img-upload" id="imgForm" style="visibility: hidden;">
      <input type="file" id="file_form" name="file" accept="image/*" /><br />
    </form>

    <input onclick="imgForm()" type="submit" value="Submit">

    <video autoplay></video>
  </div>

  <script>
      function imgForm() {
        document.getElementById("imgForm").submit();
        window.location.href = "/";
      }
  </script>

</html>
