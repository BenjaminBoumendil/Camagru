<!DOCTYPE html>
<html>

  <header style="height:50px;width:100%;background-color:black;">
    <p style="color:white;"> Welcome</p>
    <input onclick="logout()" style="float:right;" type="submit" name="action" value="Logout" />
  </header>

  <script>
    function logout() {
        console.log("logout js");
        xhttp = new XMLHttpRequest();
        xhttp.open("GET", "/?logout", true);
        xhttp.send();
        window.location.href = "/";
    }
  </script>

</html>
