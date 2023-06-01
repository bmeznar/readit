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
        <div class="main-body">
            <h2 class="title">WELCOME TO OUR FORUM</h2>
            <?php 
                echo $_SESSION['site_message'];
            ?>
            <div>
                <?php 
                foreach ($forums as $forum): 
                    $date = date("d.m.Y", strtotime($forum["date_created"])); 
                    ?>
                    <div class="forum-list-item-wrapper">
                        <a href="<?= BASE_URL . "forum?id=" . $forum["id"] ?>" class="forum-list-item">
                            <div>
                                <h5><?= $forum["title"] ?></h5> <i class="fs-14">Created on: <?= $date ?></i> <span class="num-of-posts fs-14">Number of posts: <?php echo $forum['COUNT(fm.id)'] ?></span>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <script>
        window.onload = function() {
            <?php
            // echo $_SESSION['site_message'];
            if (isset($_SESSION['site_message']) && !empty($_SESSION['site_message'])) {
                echo "alert('" . $_SESSION['site_message'] . "');";
                $_SESSION['site_message'] = "";
            }
            ?>
        };
    </script>
</body>
</html>