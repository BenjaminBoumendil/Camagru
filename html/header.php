<!DOCTYPE html>
<html>
  <style>
    header {
      width: 100%;
      height: 50px;
      background-color: black;
    }
    #header-text {
      color: white;
      text-align: left;
      text-indent: 1%;
      vertical-align: middle;
      padding-top: 15px;
    }
    input {
      float: right;
    }
  </style>

  <header>
    <p id="header-text">Welcome <?php echo $_SESSION["Username"]; ?>
      <input onclick="logout()" type="submit" name="action" value="Logout" />
      <input onclick="gallery()" type="submit" name="action" value="Gallery" />
    </p>
  </header>

  <script>
    function logout() {
        xhttp = new XMLHttpRequest();
        xhttp.open("GET", "/?logout", true);
        xhttp.send();
        window.location.reload();
    }
    function gallery() {
        window.location.href = "/gallery"
    }
  </script>

</html>

