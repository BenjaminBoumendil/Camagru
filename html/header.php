<!DOCTYPE html>
<html>

  <header style="height:50px;width:100%;background-color:black;">
    <p style="color:white;"> Welcome <?php $_SESSION['username'] ?></p>
    <a href="/?logout">
      <input style="float:right;" type="submit" name="action" value="Logout" />
    </a>
  </header>

</html>
