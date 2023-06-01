<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forum</title>
    <?php include("view/bootstrap.php"); ?>
    <link rel="stylesheet" type="text/css" href="../../assets/style.css" />
</head>
<body>

    <?php include("view/head.php"); ?>

    <div class="content-wrapper">
        <div>
            <span><a href="<?php echo BASE_URL . "forum"; ?>">< Home</a></span>
        </div>
        <div class="main-body user-search-wrapper">
            <div>
                <input type="text" placeholder="Search users 🔍" name="search" id="search_users" class="search_input">
            </div>
            <br><br>
            <h5 style="color: #FFE6C7; text-align: left;" class="search-results-span">&nbsp;&nbsp;Search results: </h5>
            <div>
                <div id="search_results">
                    <div class="search-text-info">Search for users to get results</div>
                </div>
            </div>
        </div>
    </div>

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script type="text/javascript">
    $(document).ready(function () {

        $("#search_users").on( "keyup", function() {
            const search_query = $("#search_users").val();
            document.getElementById("search_results").innerHTML="";

            if (search_query.length == 0) {
                document.getElementById("search_results").innerHTML="<div class='search-text-info'>Search for users to get results</div>";
            }

            var xhttp =new XMLHttpRequest();
            xhttp.onreadystatechange=function() {
                if (this.readyState==4 && this.status==200) {
                    const json = JSON.parse(this.responseText);
                    if (Object.keys(json).length === 0) {
                        document.getElementById("search_results").innerHTML="<div class='search-text-info'>No user found...</div>";
                    } else {
                    showSearchResults(json);
                    }
                }
            }

            xhttp.open("GET","<?= BASE_URL ?>" + "api/users/getUsers?query=" + search_query, true);
            xhttp.send();
        });

        function showSearchResults(json){
            json.forEach(user => {
                var ul = document.getElementById("search_results");
                var li = document.createElement("div");
                li.setAttribute('id', user.id);
                li.setAttribute('class', 'user-search-div')
                var a = document.createElement("a");
                a.setAttribute('class', 'forum-list-item');
                a.setAttribute('href', "<?= BASE_URL ?>" + "user?id=" + user.id);
                var icon = document.createElement("i");
                icon.setAttribute('class', 'fa-solid fa-user user-search-icon')
                var text = document.createTextNode(user.username);   
                li.appendChild(icon);
                li.appendChild(text); 
                a.appendChild(li);
                ul.appendChild(a);
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