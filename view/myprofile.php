<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forum - my profile</title>
    <link rel="stylesheet" type="text/css" href="../assets/style.css" />
    <?php include("view/bootstrap.php"); ?>
</head>
<body>

    <?php include("view/head.php"); ?>

    <div class="content-wrapper">
        <div class="login-wrapper" style="margin-top: 20px;">
            <div>
                <h2>My profile</h2>
            </div>
            <br>
            <div>
                <h4>My information</h4>
                <div>
                    <b>Username: </b> <?php echo $_SESSION['user']; ?>
                </div>
                <div>
                    <b>Email: </b> <?php echo $_SESSION['email']; ?>
                </div>
                <div>
                    <b>Birthday: </b> <?php echo date("d. M Y", strtotime($_SESSION['birthday'])); ?>
                </div>
                <button type="button" class="confirm-btn-light" data-toggle="modal" data-target="#editMyInfoModal">Edit my information</button>

                <div class="modal fade" id="editMyInfoModal" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Edit my information</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true"style="color: white;s">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="user/updateInfo" method="post">
                                <div class="user-update-wrapper">
                                    <label for="user">Username: </label>
                                    <input type="text" name="user" value="<?php echo $_SESSION['user']; ?>">
                                </div>
                                <div class="user-update-wrapper">
                                    <label for="email">Email: </label>
                                    <input type="email" name="email" value="<?php echo $_SESSION['email']; ?>">
                                </div>
                                <div class="user-update-wrapper">
                                    <label for="birthday">Birthday: </label>
                                    <input type="date" name="birthday" value="<?php echo date("Y-m-d", strtotime($_SESSION['birthday'])); ?>">
                                </div>
                                <br><br>
                                <input type="submit" value="Save changes" class="confirm-btn-light">
                            </form>
                        </div>
                    </div>
                </div>
                </div>
            </div>
            <br>
            <div>
                <h4>Change my password</h4>
                <form action="myprofile/passwordChange" method="post" class="change-password-form">
                    <input type="password" name="pass_reset" placeholder="New password" required>
                    <input type="password" name="pass_reset_repeat" placeholder="Repeat new password" required>
                    <input type="submit" value="Change my password" name="submit" class="confirm-btn-light">
                </form>
            </div>
        </div>
        <br>
        <div class="main-body">
            <h4>My forums</h4>
            <div id="search_results">

            </div>
        </div>
    </div>

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script>
    $(document).ready(function () {

        document.getElementById("search_results").innerHTML="";

        var xhttp =new XMLHttpRequest();
        xhttp.onreadystatechange=function() {
            if (this.readyState==4 && this.status==200) {
                const json = JSON.parse(this.responseText);
                if (Object.keys(json).length === 0) {
                    document.getElementById("search_results").innerHTML="<div class='search-text-info'>You haven't created any forums yet...</div>";
                } else {
                    showSearchResults(json);
                }
            }
        }

        xhttp.open("GET","<?= BASE_URL ?>" + "api/forum/getMyForums", true);
        xhttp.send();



        function showSearchResults(json){
            json.forEach(forum => {
                var dateCreated = new Date(forum.date_created);
                var day = dateCreated.getDate();
                var month = dateCreated.getMonth() + 1;
                var year = dateCreated.getFullYear();
                var formattedDate = ('0' + day).slice(-2) + '.' + ('0' + month).slice(-2) + '.' + year;

                var parent_div = document.getElementById("search_results");
                var item = document.createElement("div");
                item.classList.add("forum-list-item-wrapper");

                var a = document.createElement("a");
                a.setAttribute('href', "<?= BASE_URL ?>" + "forum?id=" + forum.id);
                a.classList.add("forum-list-item");

                var div = document.createElement("div");

                var h5 = document.createElement("h5");
                var titleText = document.createTextNode(forum.title);
                h5.appendChild(titleText);
                div.appendChild(h5);

                var i = document.createElement("i");
                i.classList.add("fs-14");
                var createdText = document.createTextNode("Created on: " + formattedDate);
                i.appendChild(createdText);
                div.appendChild(i);

                var span = document.createElement("span");
                span.classList.add("num-of-posts", "fs-14");
                var postsText = document.createTextNode("Number of posts: " + forum.comment_count);
                span.appendChild(postsText);
                div.appendChild(span);

                a.appendChild(div);
                item.appendChild(a);
                parent_div.appendChild(item);
            });
        }

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