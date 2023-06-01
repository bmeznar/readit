<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forum login</title>
    <?php include("view/bootstrap.php"); ?>
    <link rel="stylesheet" type="text/css" href="../assets/style.css" />
</head>
<body>
    <div class="login-wrapper">
        <h2>Login</h2>
        <form action="login" method="post" class="login-form">
            <input type="text" placeholder="Username" name="username" required class="fs-18">
            <input type="password" placeholder="Password" name="password" required class="fs-18">
            <input type="submit" value="Login" name="login" class="confirm-btn">
        </form>
        <div>
            Not yet registered? Register <a href="register">HERE</a>.
        </div>
        <br>
        <div><a href="guest">Continue as a guest</a></div>
    </div>
    <div class="footer">
        <h1 class="head_title">READIT</h1>
    </div>


    <script>
        window.onload = function() {
            <?php
            if (isset($_SESSION['site_message']) && !empty($_SESSION['site_message'])) {
                echo "alert('" . $_SESSION['site_message'] . "');";
                $_SESSION['site_message'] = "";
            }
            ?>
        };
    </script>
</body>
</html>