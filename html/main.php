<!DOCTYPE html>
<html>
  <style>
    #main {
        min-height: 500px;
        float: left;
        width: 75%;
        border: 10px solid grey;
    }
    #topLeft {
        float: left;
        width: 49%;
        height: 99%;
        border: 3px solid grey;
    }
    #topRight {
        float: right;
        width: 49%;
        height: 99%;
        border: 3px solid grey;
    }
    #bottomLeft {
        float: left;
        width: 49%;
        height: 99%;
        border: 3px solid grey;
    }
    #bottomRight {
        float: right;
        width: 49%;
        height: 99%;
        border: 3px solid grey;
    }
    #top {
        height: 50%;
    }
    #bottom {
      height: 50%;
    }
  </style>

  <div id="main">

    <div id="top">

      <div id="topLeft">
        <video autoplay></video>
      </div>

      <div id="topRight">
        <img id="imgMain" src='' />
        <canvas></canvas>
      </div>

    </div>

    <div id="bottom">

      <div id="bottomLeft">
        <form method="POST" enctype="multipart/form-data" id="imgForm" style="visibility: hidden;">
          <input type="file" name="file" accept="image/*" /><br />
          <input type="hidden" name='action' value="image">
          <input onclick="imgForm()" type="button" value="Submit">
        </form>
      </div>

      <div id="bottomRight">
      </div>

    </div>

  </div>

  <script>
      function imgForm() {
        document.getElementById("imgForm").submit();
        window.location.reload();
      }
  </script>

</html>
