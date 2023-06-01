<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forum</title>
    <link rel="stylesheet" type="text/css" href="../../assets/style.css" />
    <?php include("view/bootstrap.php"); ?>
</head>
<body>
    
    <?php include("view/head.php"); ?>

    <div class="content-wrapper">
        <div>
            <a href="<?php echo BASE_URL; ?>forum">< Home</a>
        </div>
        <div class="main-body">
            <h3 class="h3-header">Create new  forum</h3>
            <br>
            <form action="add" method="post" class="new-forum-form" enctype="multipart/form-data">
                <input type="text" placeholder="title" name="title" required class="title-input">
                <br>
                <textarea name="message" id="" cols="30" rows="10" placeholder="message"></textarea>
                <!-- <input type="file" name="fileToUpload"> -->
                <input type="submit" value="Post" name="submit" class="confirm-btn">
            </form>
        </div>
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