<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forum registration</title>
    <link rel="stylesheet" type="text/css" href="../assets/style.css" />
    <?php include("view/bootstrap.php"); ?>
</head>
<body>
    <div class="login-wrapper">
        <h2>Registration</h2>
        <form action="register" method="post" class="login-form">
            <input type="email" placeholder="Email" name="email" required class="fs-18">
            <input type="text" placeholder="Username" name="username" required class="fs-18">
            <input type="date" placeholder="Date of birth" name="birthday" required class="fs-18">
            <input type="password" placeholder="Password" name="password" required class="fs-18">
            <input type="password" placeholder="Repeat password" name="repeat_password" required class="fs-18">
            <input type="submit" value="Register" name="register" class="confirm-btn">
        </form>
        <div>
            Already registered? Login <a href="login">HERE</a>.
        </div>
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