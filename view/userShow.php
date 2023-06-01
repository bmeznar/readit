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
        <div class="login-wrapper" style="margin-top: 20px;">
            
            <h4>User information</h4>
            <div>
                <b>Username: </b> <span class="fs-18"><?php echo $data['username']; ?></span>
            </div>
            <div>
                <b>Email: </b> <span class="fs-18"><?php echo $data['email']; ?></span>
            </div>
            <div>
                <b>Birthday: </b> <span class="fs-18"><?php echo date("d. M Y", strtotime($data['birthday'])); ?></span>
            </div>
            <br>
            <button id="send_dm" class="confirm-btn-light">Send direct message</button>
            <form action="messages/sendMessage" method="post" id="dm_form" style="display: none">
                <input type="hidden" name="reciever_id" value="<?php echo $data['id']; ?>">
                <textarea name="message" id="" cols="30" rows="10"></textarea>
                <input type="submit" value="Send" class="confirm-btn-light">
                <button type="button" id="dm_cancel" class="confirm-btn-light">Cancel</button>
            </form>
        </div>
        <br>
        <div class="main-body">
            <h4>Users forums</h4>
            <div id="search_results">
            </div>
        </div>
    </div>


    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script>
        $('#send_dm').on("click", function() {
            $('#dm_form').toggle();
            $('#send_dm').toggle();
        });

        $('#dm_cancel').on("click", function() {
            $('#dm_form').toggle();
            $('#send_dm').toggle();
        });



    $(document).ready(function () {

        document.getElementById("search_results").innerHTML="";

        var xhttp =new XMLHttpRequest();
        xhttp.onreadystatechange=function() {
            if (this.readyState==4 && this.status==200) {
                const json = JSON.parse(this.responseText);
                if (Object.keys(json).length === 0) {
                    document.getElementById("search_results").innerHTML="<div class='search-text-info'>User hasn't created any forums yet...</div>";
                } else {
                    showSearchResults(json);
                }
            }
        }
        console.log( <?= $_GET['id'] ?>);
        xhttp.open("GET","<?= BASE_URL ?>" + "api/forum/getUserForums?user_id=" + <?= $_GET['id'] ?>, true);
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