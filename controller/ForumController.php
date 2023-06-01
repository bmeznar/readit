<?php

require_once("model/ForumDB.php");
require_once("ViewHelper.php");

class ForumController {

    public static function index() {
        if (isset($_GET["id"])) {
            $forum = ForumDB::get($_GET["id"]);
            $comments = ForumDB::getComments($_GET["id"]);
            $likes = ForumDB::getAllUserLikes($_GET["id"]);
            ViewHelper::render("view/forum.php", ["forum" => $forum, "comments" => $comments, "myLikes" => $likes]);
        } else {
            ViewHelper::render("view/forum_list.php", ["forums" => ForumDB::getAllForums()]);
        }
    }

    public static function login() {
        ViewHelper::render("view/login.php");
    }

    public static function loginVerify() {
        $validData =    isset($_POST["username"]) && !empty($_POST["username"]) && 
                        isset($_POST["password"]) && !empty($_POST["password"]);

        if ($validData) {
            $users = ForumDB::login($_POST["username"], $_POST["password"]);

            if ($users != null) {
                if (password_verify($_POST["password"], $users[0]['password'])) {
                    $_SESSION['user_id'] = $users[0]['id'];
                    $_SESSION['user'] = $users[0]['username'];
                    $_SESSION['email'] = $users[0]['email'];
                    $_SESSION['birthday'] = $users[0]['birthday'];
                    ViewHelper::redirect(BASE_URL . "forum");
                }
                else {
                    $_SESSION['site_message'] = "Wrong password.";
                    echo "narobe :/";
                    self::login();
                }
            }
            else {
                $_SESSION['site_message'] = "Wrong username";
                self::login();
            }
        } else {
            $_SESSION['site_message'] = "Missing login data!";
            self::login();
        }
    }

    public static function register() {
        ViewHelper::render("view/register.php");
    }

    public static function registerVerify() {
        $validData =    isset($_POST["username"]) && !empty($_POST["username"]) && 
                        isset($_POST["password"]) && !empty($_POST["password"]) &&
                        isset($_POST["repeat_password"]) && !empty($_POST["repeat_password"]) &&
                        isset($_POST["email"]) && !empty($_POST["email"]) &&
                        isset($_POST["birthday"]) && !empty($_POST["birthday"]);

        if ($validData) {
            $users = ForumDB::checkEmail($_POST["email"]);
            if ($users != null) {
                $_SESSION['site_message'] = "This email is already registered.";
                // echo "sori email je že registriran :/";
                self::register();
            }
            else {
                $users = ForumDB::checkUsername($_POST["username"]);
                if ($users != null) {
                    // echo "sori uporabnik obstaja :/";
                    $_SESSION['site_message'] = "This username is already taken. Please choose anbother one.";
                    self::register();
                }
                else {
                    if ($_POST["password"] == $_POST["repeat_password"]) {
                        ForumDB::registerUser($_POST["username"], $_POST["password"], $_POST["email"], $_POST["birthday"]);
                        ViewHelper::redirect(BASE_URL . "registerSuccess");
                    }
                    else {
                        // echo "gesla nista ista sori šef :/";
                        $_SESSION['site_message'] = "Passwords do not match";
                        self::register();
                    }
                }
            }
        } else {
            $_SESSION['site_message'] = "Missing registration informations!";
            self::register();
        }
    }

    public static function registerSuccess() {
        ViewHelper::render("view/registerSuccess.php");
    }

    public static function addForumForm() {
        ViewHelper::render("view/addForum.php");
    }

    public static function AddForum() {
        $validData =    isset($_POST["title"]) && !empty($_POST["title"]) && 
                        isset($_POST["message"]) && !empty($_POST["message"]);

        if ($validData) {
            ForumDB::createNewForum($_POST["title"], $_POST["message"]);
            ViewHelper::redirect(BASE_URL . "");
            // if (isset($_FILES["fileToUpload"]["name"]) && !empty($_FILES["fileToUpload"]["name"])) {
            //     $success = true;
            //     $target_dir = "uploads/";
            //     $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
            //     $uploadOk = 1;
            //     $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

            //     if(isset($_POST["submit"])) {
            //     $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
            //     if($check !== false) {
            //         echo "File is an image - " . $check["mime"] . ".";
            //         $uploadOk = 1;
            //     } else {
            //         echo "File is not an image.";
            //         $success = false;
            //         $_SESSION['site_message'] = "File is not an image. Forum was not created.";
            //         $uploadOk = 0;
            //     }
            //     }

            //     if (file_exists($target_file)) {
            //         echo "Sorry, file already exists.";
            //         $success = false;
            //         $_SESSION['site_message'] = "Sorry file already exists. Forum was not created.";
            //         $uploadOk = 0;
            //     }

            //     if ($_FILES["fileToUpload"]["size"] > 500000) {
            //         echo "Sorry, your file is too large.";
            //         $success = false;
            //         $_SESSION['site_message'] = "File is too big. Forum was not created.";
            //         $uploadOk = 0;
            //     }

            //     if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            //     && $imageFileType != "gif" ) {
            //         echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            //         $success = false;
            //         $_SESSION['site_message'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed. Forum was not created.";
            //         $uploadOk = 0;
            //     }

            //     if ($uploadOk == 0) {
            //         echo "Sorry, your file was not uploaded.";
            //         $success = false;
            //     } else {
            //         if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                        
            //             echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
            //         } else {
            //             echo "Sorry, there was an error uploading your file.";
            //             $success = false;
            //             $_SESSION['site_message'] = "Sorry, there was an error uploading your file. Forum was not created.";
            //         }
            //     }
            //     if ($success == true) {
            //         $filename = htmlspecialchars( basename( $_FILES["fileToUpload"]["name"]));
            //         //echo $filename;
            //         ForumDB::createNewForumWithImage($_POST["title"], $_POST["message"], $filename);
            //         ViewHelper::redirect(BASE_URL . "");
            //     }
            //     else {
            //         echo $_SESSION['site_message'];
            //         ViewHelper::redirect(BASE_URL . "forum/add");
            //     }
            // }
            // else {
                // ForumDB::createNewForum($_POST["title"], $_POST["message"]);
                // ViewHelper::redirect(BASE_URL . "");
            // }

            //ForumDB::createNewForum($_POST["title"], $_POST["message"]);
            //ViewHelper::redirect(BASE_URL . "");
        } else {
            $_SESSION['site_message'] = "There was missing data when creating forum. Please make sure you fill out all the fields.";
            // echo "manjkajoči podatki";
            self::addForumForm();
        }
    }

    public static function searchForum() {
        ViewHelper::render("view/searchForum.php");
    }

    public static function searchForumApi() {
        if (isset($_GET["query"]) && !empty($_GET["query"])) {
            $hits = ForumDB::searchForums($_GET["query"]);
        } else {
            $hits = [];
        }

        header('Content-type: application/json; charset=utf-8');
        echo json_encode($hits);
    }

    public static function getAllForumApi() {
        $hits = ForumDB::getAllApiForums();

        header('Content-type: application/json; charset=utf-8');
        echo json_encode($hits);
    }

    public static function getMyForumsApi() {
        $hits = ForumDB::searchUsersForums($_SESSION["user_id"]);

        header('Content-type: application/json; charset=utf-8');
        echo json_encode($hits);
    }

    public static function getUserForumsApi() {
        $hits = ForumDB::searchUsersForums($_GET["user_id"]);

        header('Content-type: application/json; charset=utf-8');
        echo json_encode($hits);
    }

    public static function myprofile() {
        ViewHelper::render("view/myprofile.php");
    }

    public static function passwordUpdate() {
        $validData =    isset($_POST["pass_reset"]) && !empty($_POST["pass_reset"]) && 
                        isset($_POST["pass_reset_repeat"]) && !empty($_POST["pass_reset_repeat"]);

        if ($validData) {
            if ($_POST["pass_reset"] == $_POST["pass_reset_repeat"]) {
                ForumDB::updatePassword($_POST["pass_reset"]);
                $_SESSION['site_message'] = "Password successfully updated.\\nYou need to login with new password.";
                ViewHelper::redirect(BASE_URL . "logout");
            }
            else{
                echo "gesla nista ista šefe!";
                $_SESSION['site_message'] = "Passwords do not match :(";
                ViewHelper::redirect(BASE_URL . "myprofile");
            }
        } else {
            echo "manjkajoči podatki";
            $_SESSION['site_message'] = "Missing input data!";
            ViewHelper::redirect(BASE_URL . "myprofile");
        }
    }

    public static function addComment() {
        $validData =    isset($_POST["comment"]) && !empty($_POST["comment"]) &&
                        isset($_POST["id"]) && !empty($_POST["id"]);

        if ($validData) {
            ForumDB::createNewComment($_POST["comment"], $_POST["id"]);
            ViewHelper::redirect(BASE_URL . "forum?id=" . $_POST['id']);
        } else {
            $_SESSION['site_message'] = "Missing data. Please make sure you fill out all the fields.";
            // echo "manjkajoči podatki";
            ViewHelper::redirect(BASE_URL . "forum?id=" . $_POST['id']);
        }
    }

    public static function editComment() {
        $validData =    isset($_POST["comment"]) && !empty($_POST["comment"]) &&
                        isset($_POST["forum_id"]) && !empty($_POST["forum_id"])&&
                        isset($_POST["comment_id"]) && !empty($_POST["comment_id"]);

        if ($validData) {
            ForumDB::editComment($_POST["comment"], $_POST["comment_id"]);
            ViewHelper::redirect(BASE_URL . "forum?id=" . $_POST['forum_id']);
        } else {
            $_SESSION['site_message'] = "Missing data. Please make sure you don't leave any empty fields.";
            self::forum();
        }
    }

    public static function updateUserInfo() {
        $validData =    isset($_POST["user"]) && !empty($_POST["user"]) &&
                        isset($_POST["email"]) && !empty($_POST["email"])&&
                        isset($_POST["birthday"]) && !empty($_POST["birthday"]);

        if ($validData) {
            $usefull_info = true;

            if ($_POST['user'] != $_SESSION['user']) {
                $users = ForumDB::checkUsername($_POST["user"]);
                if ($users != null) {
                    $_SESSION['site_message'] = "Username " . $_POST["user"] . "is already taken.\\nCannot update your information.";
                    $usefull_info = false;
                    ViewHelper::redirect(BASE_URL . "myprofile");
                }
            }
            if ($_POST['email'] != $_SESSION['email']) {
                $users = ForumDB::checkEmail($_POST["email"]);
                if ($users != null) {
                    $_SESSION['site_message'] = "Email " . $_POST["email"] . "is already used.\\nCannot update your information.";
                    $usefull_info = false;
                    ViewHelper::redirect(BASE_URL . "myprofile");
                }
            }

            if ($usefull_info == true) {
                ForumDB::editUser($_POST["user"], $_POST["email"], $_POST["birthday"]);
                ViewHelper::redirect(BASE_URL . "myprofile");
            }

        } else {
            $_SESSION['site_message'] = "There was some missing information when trying to update your information.\\nYour profile was not updated.";
            ViewHelper::redirect(BASE_URL . "myprofile");
        }
    }

    public static function myMessages() {
        ViewHelper::render("view/myMessages.php", ["messages" => ForumDB::myDMs()]);
    }

    public static function noAccess() {
        ViewHelper::render("view/noAccess.php");
    }

    public static function messageLikes() {
        $hits = ForumDB::messageLikes(2);

        header('Content-type: application/json; charset=utf-8');
        echo json_encode($hits);
    }

    public static function likeMessage() {
        $validData =    isset($_GET["message_id"]) && !empty($_GET["message_id"]) &&
                        isset($_GET["forum_id"]) && !empty($_GET["forum_id"]);

        if ($validData) {
            ForumDB::likeMessage($_GET["message_id"]);
            ViewHelper::redirect(BASE_URL . "forum?id=" . $_GET["forum_id"]);
        } else {
            $_SESSION['site_message'] = "An error occured when liking this message. Please try again later.";
            self::forum();
        }
    }

    public static function unlikeMessage() {
        $validData =    isset($_GET["message_id"]) && !empty($_GET["message_id"]) &&
                        isset($_GET["forum_id"]) && !empty($_GET["forum_id"]);

        if ($validData) {
            ForumDB::unlikeMessage($_GET["message_id"]);
            ViewHelper::redirect(BASE_URL . "forum?id=" . $_GET["forum_id"]);
        } else {
            $_SESSION['site_message'] = "An error occured when unliking this message. Please try again later.";
            self::forum();
        }
    }

}