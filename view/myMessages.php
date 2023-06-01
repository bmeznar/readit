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
    
    <?php include("view/head.php"); ?>

    <div class="content-wrapper">
        <div class="messages-wrapper">
            <div>
                <h3>My messages</h3>
            </div>
            <div class="my-conversations">
                <?php
                foreach ($messages as $message):
                    ?>

                    <a href="<?= BASE_URL . "messages?id=" . $message["id"] ?>" class="forum-list-item"> <div>
                        <?= $message["username"] ?>
                    </div></a>
                <?php endforeach;
                ?>
            </div>
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