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

      var video = document.querySelector('video');
      var canvas = document.querySelector('canvas');
      var ctx = canvas.getContext('2d');
      var localMediaStream = null;

      function uploadFile() {
        var file = document.getElementById("file_form").files[0];
        xhttp = new XMLHttpRequest();
        xhttp.open("POST", "/?img-upload", true);
        xhttp.onload = function() {
          if (xhttp.status === 202) {
              console.log("FILE UPLOADED");
          }
        };
        xhttp.send(file);
      }

      var errorCallback = function(e) {
        document.getElementById("imgForm").style.visibility = "visible";
        canvas.style.visibility = "hidden";
      };

      function fallback() {
        console.log('getUserMedia missing');
      }

      function snapshot() {
        if (localMediaStream) {
          ctx.drawImage(video, 0, 0, 720, 720, 0, 0, 720, 720);
          // "image/webp" works in Chrome.
          // Other browsers will fall back to image/png.
          document.querySelector('img').src = canvas.toDataURL('image/webp');

          // send Image to server
          var file = document.getElementById('img-cam').src,
          xhr = new XMLHttpRequest();
          xhr.open('POST', '/?img-upload', true);
          xhr.send(file);
        }
      }

      navigator.getUserMedia  = navigator.getUserMedia ||
                                navigator.webkitGetUserMedia ||
                                navigator.mozGetUserMedia ||
                                navigator.msGetUserMedia;

      if (!navigator.getUserMedia) {
        fallback();
      } else {
        var sizeConstraints = {
          video: {
            mandatory: {
              maxWidth: 720,
              maxHeight: 720
            }
          }
        };

        video.addEventListener('click', snapshot, false);

        navigator.getUserMedia(sizeConstraints, function(stream) {
            video.src = window.URL.createObjectURL(stream);
            localMediaStream = stream;

            video.onloadedmetadata = function(e) {
              // Ready to go. Do some stuff.
            };
        }, errorCallback);
      }
  </script>

</html>
