<!DOCTYPE html>
<html>

<form method="POST" id="registerForm">
    <p>Register Form</p><br />

    <p>Username</p>
    <input type="text" name="username" /><br />

    <p>Email</p>
    <input type="text" name="email" /><br />

    <p>Password</p>
    <input type="password" name="password" /><br /><br />

    <input onclick="loggingForm();" type="button" value="Register" />
    <input onclick="loggingForm();" type="button" value="Login" />
</form>


<script>
    function loggingForm() {
        document.getElementById("registerForm").submit();
        window.location.reload();
    }
</script>

</html>
