<!DOCTYPE html>
<html>

<form onsubmit="refresh();" method="POST" action="" id="registerForm">
    <p>Register Form</p><br />

    <p>Username</p>
    <input type="text" name="username" /><br />

    <p>Email</p>
    <input type="text" name="email" /><br />

    <p>Password</p>
    <input type="password" name="password" /><br /><br />
    <input type="submit" name="action" value="register" />
    <input type="submit" name="action" value="login" />
</form>


<script>
    function refresh() {
        // document.getElementById("registerForm").submit();
        // window.location.href = "/";
        // window.location.reload();
        // xhttp = new XMLHttpRequest();
        // xhttp.open("GET", "/", true);
        // xhttp.send();
        // window.location.reload();
        // window.location.refresh(true);
        // alert("test");
        return false;
    }
</script>

</html>
