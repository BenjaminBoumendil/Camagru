<!DOCTYPE html>
<html>

<form method="POST" action="" id="registerForm">
    <p>Register Form</p><br />

    <p>Username</p>
    <input type="text" name="username" /><br />

    <p>Email</p>
    <input type="text" name="email" /><br />

    <p>Password</p>
    <input type="password" name="password" /><br /><br />
</form>

<input onclick="register()" type="submit" name="action" value="register" />
<input onclick="register()" type="submit" name="action" value="login" />

<script>
    function register() {
        document.getElementById("registerForm").submit();
        window.location.href = "/";
    }
</script>

</html>
