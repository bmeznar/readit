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
        <h2>Registration successfull!</h2>
        <p>To continue please login with registered data.</p>
        <p><a href="login">LOGIN</a></p>
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