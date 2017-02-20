<!DOCTYPE html>
<html>
  <style>
    header {
      width: 100%;
      height: 50px;
      background-color: black;
    }
    #white-text {
      color: white;
      text-align: left;
      text-indent: 1%;
      vertical-align: middle;
      padding-top: 15px;
    }
    #header-right {
      float: right;
    }
  </style>

  <header>
    <div id="white-text">
      <a href="/">Home</a>
      Welcome
      <?php echo $_SESSION["Username"]; ?>
      <input id='header-right' onclick="logout()" type="submit" name="action" value="Logout" />
      <input id='header-right' onclick="gallery()" type="submit" name="action" value="Gallery" />
    </div>
  </header>

  <script>
    function logout() {
        xhttp = new XMLHttpRequest();
        xhttp.open("GET", "/?logout", true);
        xhttp.send();
        window.location.reload();
    }
    function gallery() {
        window.location.href = "/gallery";
    }
  </script>

</html>

