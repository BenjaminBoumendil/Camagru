<!DOCTYPE html>
<html>
<head>

  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" type="text/css" href="/css/register.css">

    <title>Login</title>
  </head>

  <div id="registerDiv">
    <form method="POST" id="registerForm">
      <p>Register Form</p><br />

      <p>Username</p>
      <input type="text" name="username" /><br />

      <p>Email</p>
      <input type="text" name="email" /><br />

      <p>Password</p>
      <input type="password" name="password" /><br /><br />

      <input type="hidden" id="registerHidden" name='action' value="" />
      <input onclick="register();" type="button" name='action' value="Register" />
      <input onclick="login();" type="button" name='action' value="Login" />
    </form>
  </div>

  <script>
    function register() {
        document.getElementById('registerHidden').value = "register";
        sendForm();
    }

    function login() {
        document.getElementById('registerHidden').value = "login";
        sendForm();
    }

    function sendForm() {
        document.getElementById("registerForm").submit();
        window.location.reload();
    }
  </script>

</html>
