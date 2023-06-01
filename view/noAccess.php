<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forum</title>
    <link rel="stylesheet" type="text/css" href="../assets/style.css" />
    <?php include("view/bootstrap.php"); ?>
</head>
<body>
<div class="login-wrapper">
        <h2>Forbidden!</h2>
        <p>
            As a guest you dont have permission for this action. <br>
            You need to login or register to use this function.
        </p>
        <div>
            Log in <a href="<?php echo BASE_URL; ?>login">HERE</a>.
        </div>
        <div>
            Not yet registered? Register <a href="<?php echo BASE_URL; ?>register">HERE</a>.
        </div>
        <br>
        <div><a href="<?php echo BASE_URL; ?>forum">Take me  back home</a></div>
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