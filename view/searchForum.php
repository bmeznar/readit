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
            <span><a href="<?php echo BASE_URL . "forum"; ?>">< Home</a></span>
        </div>
        <div class="main-body">
            <div class="search_input_wrapper">
                <input type="text" placeholder="Search forums 🔍" name="search" id="search_forums" class="search_input">
            </div>
            
            <br><br>
            <h5 style="color: #FFE6C7" class="search-results-span">&nbsp;&nbsp;Search results: </h5>
            <div id="search_results">
                <div class="search-text-info">Search for forums to get results</div>
            </div>
        </div>
    </div>


    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script type="text/javascript">
    $(document).ready(function () {

        $("#search_forums").on( "keyup", function() {
            const search_query = $("#search_forums").val();
            document.getElementById("search_results").innerHTML="";

            if (search_query.length == 0) {
                document.getElementById("search_results").innerHTML="<div class='search-text-info'>Search for forums to get results</div>";
                return;
            }

            var xhttp =new XMLHttpRequest();
            xhttp.onreadystatechange=function() {
                if (this.readyState==4 && this.status==200) {
                    const json = JSON.parse(this.responseText);
                    if (Object.keys(json).length === 0) {
                        document.getElementById("search_results").innerHTML="<div class='search-text-info'>No forum found...</div>";
                    } else {
                        showSearchResults(json);
                    }
                    
                }
            }

            xhttp.open("GET","<?= BASE_URL ?>" + "api/forum/search?query=" + search_query, true);
            xhttp.send();
        });

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