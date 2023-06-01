<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forum - messages</title>
    <link rel="stylesheet" type="text/css" href="../assets/style.css" />
    <?php include("view/bootstrap.php"); ?>
</head>
<body>

    <?php include("view/head.php"); ?>
    
    <div class="content-wrapper">
        <div class="messages-wrapper">
            <div class="all-messages-sent">
                <?php
                $sender = 0;
                //var_dump($messages);
                foreach ($messages as $message): 
                    $date = date("d.m.Y  H:i", strtotime($message["date"])); 
                    if ($message['sender_id'] == $_SESSION['user_id']) { 
                        ?>
                        <div class="message-right">
                            <?php
                            if ($sender != 1) { ?>
                                <div class="fs-18">You<i class="fa-solid fa-circle-user right-message-icon"></i></div>
                            <?php } ?>
                            <div class="message-body-wrapper">
                                <span class="message-body"><?= $message["message"] ?></span>
                            </div>
                            <div class="message-time"><i class="fs-12"><?= $date ?></i></div>
                        </div>
                    <?php
                        if ($sender == 0) {
                            $sender = 1;
                        }
                        else if($sender == 2) {
                            $sender = 1;
                        }
                    }
                    else { ?>
                        <div class="message-left">
                            <?php
                            if ($sender != 2) { ?>
                                <div class="fs-18"><i class="fa-regular fa-circle-user left-message-icon"></i><?= $message["username"] ?></div>
                            <?php } ?>
                            <div class="message-body-wrapper">
                                <span class="message-body"><?= $message["message"] ?></span>
                            </div>
                            <div class="message-time"><i class="fs-12"><?= $date ?></i></div>
                        </div>
                    <?php
                        if ($sender == 0) {
                            $sender = 2;
                        }
                        else if($sender == 1) {
                            $sender = 2;
                        }
                    }
                endforeach; ?>
            </div>


            <hr class='forum-hr'>
            <div style="margin-top: 20px;">
                <form action="messages/sendMessage" method="post" class="send-dm-form">
                    <input type="hidden" name="reciever_id" value="<?= $reciever ?>">
                    <!-- <input type="text" name="message" required  class="dm-text"> -->
                    <textarea name="message" id="" class="dm-text"></textarea>
                    <input type="submit" value="Send" class="dm-send-btn confirm-btn">
                </form>
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