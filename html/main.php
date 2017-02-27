<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" type="text/css" href="/css/main.css">
  </head>

  <div id="main">

    <div id="top">

      <div class="div-responsive">
        <video autoplay></video>
      </div>

      <div class="div-responsive" align='center'>
        <img id="imgMain" />
        <canvas style="display:none;" width="" height=""></canvas>
      </div>

    </div>

    <div id="bottom">

      <div class="div-responsive" align='center'>
        <p class="text-center">Upload your file:</p>
        <br />
        <form method="POST" enctype="multipart/form-data" id="imgForm">
          <input id="fileInput" type="file" name="file" accept="image/*" /><br />
          <input type="hidden" name='action' value="image">
          <input onclick="imgForm()" type="button" value="Submit">
        </form>
      </div>

      <div class="div-responsive">
      </div>

    </div>

  </div>

  <script>
      var fileInput = document.getElementById('fileInput');

      fileInput.onchange = function(evt) {
          var file = evt.target.files[0];
          var reader = new FileReader();

          reader.onload = (function(file) {
              return function(e) {
                var imgMain = document.getElementById('imgMain');

                imgMain.src = e.target.result;
              };
          })(file);

          reader.readAsDataURL(file);
      };

      function imgFormToimgMain() {
        console.log(document.getElementById("fileInput").files[0]);
        document.getElementById("imgMain").src = document.getElementById("fileInput").files[0];
      }

      function imgForm() {
        document.getElementById("imgForm").submit();
        window.location.reload();
      }
  </script>

</html>
