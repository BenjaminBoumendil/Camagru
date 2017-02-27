<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" type="text/css" href="/css/header.css">
  </head>

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

