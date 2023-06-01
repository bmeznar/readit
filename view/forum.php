<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forum</title>
    <?php include("view/bootstrap.php"); ?>
    <link rel="stylesheet" type="text/css" href="../assets/style.css" />
</head>
<body>

    <?php include("view/head.php"); ?>

    <div class="content-wrapper">
        <div>
            <a href="forum">< Home</a>
        </div>
        <br>
        <div class="forum-post-wrapper">
            <div>
                <h3 class="forum-title">
                    <?php 
                        echo $forum[0]['title'];            
                    ?>
                </h3>
                <div>
                    &nbsp;&nbsp;Created by:&nbsp;
                    <i>
                        <?php
                        $date = date("d.m.Y G:i", strtotime($forum[0]['date_created']));
                        echo "<b>" . $comments[0]['username'] . "</b> (" .$date . ")";
                        ?>
                    </i>
                </div>
                <br>
                <div class="first-post">
                    <?php
                    $date = date("d.m.Y G:i", strtotime($comments[0]['date'])); 
                    //echo $comments[0]['message'] . " (" . $date . ")";  
                    echo $comments[0]['message'];
                    ?>
                </div>
            </div>
            <br>
            <div>
                <?php
                $myLikes = array_values(array_column($myLikes, 'forum_message_id'));
                // var_dump($myLikes);
                $firstValue = array_shift($comments);
                
                foreach ($comments as $comment) {
                    echo "<hr class='forum-hr'>";
                    $edited = false;
                    if ($comment['date'] != $comment['edited_date']) {
                        $edited = true;
                    }
                    $date = date("d.m.Y G:i", strtotime($comment['date'])); 
                    echo "<div><div>";
                    echo "<span class='comment-info'><h5 class='username-header'><i class='fa-regular fa-circle-user'></i> " . $comment['username'] . "</h5>  (Posted: " . $date . ")</span>";
                    echo "<p id='message_" . $comment['id'] . "'>" . $comment['message'] . "</p>";

                    if ($edited == true) {
                        echo " <i class='fs-14'>(edited: " . date("d.m.Y G:i", strtotime($comment['edited_date'])) . ")</i>";
                    }
                    echo "</div>";
                    if (isset($_SESSION['user_id']) && $comment['user_id'] == $_SESSION['user_id']) {
                        ?>
                        <div class="edit-comment-wrapper">
                            <button class="edit_message confirm-btn" id="<?php echo $comment['id']; ?>">Edit message</button>
                            <div class="delete-message-<?php echo $comment['id']; ?>">
                                <form action="message/delete" method="post">
                                    <input type="hidden" name="message_id" value="<?php echo $comment['id']; ?>">
                                    <input type="hidden" name="forum_id" value="<?php echo $_GET['id'] ?>">
                                    <input type="submit" value="Delete" class="confirm-btn">
                                </form>
                            </div>
                            <form id="message_edit_form_<?php echo $comment['id']; ?>" action="forum/editComment" method="post" style="display: none; width: 100%;">
                                <input type="hidden" value="<?php echo $comment['forum_id']; ?>" name="forum_id">
                                <input type="hidden" value="<?php echo $comment['id']; ?>" name="comment_id">
                                <textarea name="comment" id=""><?php echo $comment['message']; ?></textarea>
                                <br>
                                <input type="submit" value="Update" class="confirm-btn confirm-btn"/>
                                <button type="button" class="edit_message_cancel confirm-btn" id="<?php echo $comment['id']; ?>">Cancel</button>
                            </form>
                        </div>
                    <?php
                    }?>
                    </div><br>
                    <div class="message-likes">
                        <?php
                        if (in_array($comment['id'], $myLikes)){ ?>
                            <a href="forum/unlikeMessage?message_id=<?php echo $comment['id']; ?>&forum_id=<?php echo $_GET['id']; ?>">
                                <i class="fa-solid fa-thumbs-up"></i>
                            </a>
                            <?php echo $comment['likes'];
                        }
                        else { ?>
                            <a href="forum/likeMessage?message_id=<?php echo $comment['id']; ?>&forum_id=<?php echo $_GET['id']; ?>">
                                <i class="fa-regular fa-thumbs-up"></i>
                            </a>
                            <?php echo $comment['likes'];
                        } ?>
                        
                    </div>
                <?php } ?>
            </div>
            <br>
            <hr class='forum-hr'>
            <br>
            <div>
                <?php
                if (isset($_SESSION['user_id'])) { ?>
                <button id="add_comment_btn" class="confirm-btn">Add comment</button>
                <form action="forum/addComment" method="post" style="display: none;" id="add_comment_form">
                    <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
                    <textarea name="comment"></textarea>
                    <br>
                    <input type="submit" value="Post" class="confirm-btn">
                    <input type="reset" value="Clear" class="confirm-btn">
                    <button type="button" id="cancel_btn" class="confirm-btn">Cancel</button>
                </form>
                <?php } ?>
            </div>
        </div>
    </div>


    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script>
        $('#add_comment_btn').on("click", function() {
            $('#add_comment_form').show();
            $('#add_comment_btn').hide();
        });

        $('#cancel_btn').on("click", function() {
            $('#add_comment_form').hide();
            $('#add_comment_btn').show();
        });


        $('.edit_message').on('click', function() {
            var buttonId = $(this).attr('id');
            $('#' + buttonId).hide();
            $('#message_edit_form_' + buttonId).show();
            $('#message_' + buttonId).hide();
            $('.delete-message-' + buttonId).hide();
        });

        $('.edit_message_cancel').on('click', function() {
            var buttonId = $(this).attr('id');
            $('#' + buttonId).show();
            $('#message_edit_form_' + buttonId).hide();
            $('#message_' + buttonId).show();
            $('.delete-message-' + buttonId).show();
        });


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