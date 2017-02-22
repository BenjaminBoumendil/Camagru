<!DOCTYPE html>
<html>
  <style>
    #main {
        float: left;
        width: 75%;
        border: 10px solid grey;
    }
    #topLeft {
        float: left;
        width: 49%;
        height: 99%;
        /*border: 3px solid grey;*/
    }
    #topRight {
        float: right;
        width: 49%;
        height: 99%;
        /*border: 3px solid grey;*/
    }
    #bottomLeft {
        float: left;
        width: 49%;
        height: 99%;
        /*border: 3px solid grey;*/
    }
    #bottomRight {
        float: right;
        width: 49%;
        height: 99%;
        /*border: 3px solid grey;*/
    }
    #top {
      height: 50%;
    }
    #bottom {
      height: 50%;
    }
    #imgMain {
      width: 100%;
      height: 100%;
    }
    #imgForm {
      position: relative;
      top: 40%;
      left: 40%;
    }
  </style>

  <div id="main">

    <div id="top">

      <div id="topLeft">
        <video autoplay></video>
      </div>

      <div id="topRight">
        <img id="imgMain" />
        <canvas style="display:none;" width="" height=""></canvas>
      </div>

    </div>

    <div id="bottom">

      <div id="bottomLeft">
        <form method="POST" enctype="multipart/form-data" id="imgForm">
          <input id="fileInput" type="file" name="file" accept="image/*" /><br />
          <input type="hidden" name='action' value="image">
          <input onclick="imgForm()" type="button" value="Submit">
        </form>
      </div>

      <div id="bottomRight">
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
