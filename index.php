<?php

session_start();

require_once("controller/ForumController.php");
require_once("controller/MessagesController.php");
require_once("controller/UserController.php");

define("BASE_URL", $_SERVER["SCRIPT_NAME"] . "/");
define("ASSETS_URL", rtrim($_SERVER["SCRIPT_NAME"], "index.php") . "assets/");

$path = isset($_SERVER["PATH_INFO"]) ? trim($_SERVER["PATH_INFO"], "/") : "";

$_SESSION['site_message'] = "";

$urls = [
    "forum" => function () {
        /*if(isset($_SESSION['user'])) {
            ForumController::index();
        }
        else {
            ViewHelper::redirect(BASE_URL . "login");
        }*/
        ForumController::index();
    },
    "login" => function () {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            ForumController::loginVerify();
        } else {
            ForumController::login();
        }
    },
    "logout" => function () {
        unset($_SESSION['user']);
        unset($_SESSION['user_id']);
        unset($_SESSION['email']);
        unset($_SESSION['birthday']);
        ViewHelper::redirect(BASE_URL . "login");
    },
    "register" => function () {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            ForumController::registerVerify();
        } else {
            ForumController::register();
        }
        //ForumController::register();
    },
    "registerSuccess" => function () {
        ForumController::registerSuccess();
    },
    "forum/add" => function () {
        if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) {
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                ForumController::AddForum();
            } else {
                ForumController::addForumForm();
            }
        }
        else {
            ForumController::noAccess();
        }
    },
    "forum/search" => function() {
        ForumController::searchForum();
    },
    "api/forum/search" => function() {
        ForumController::searchForumApi();
    },
    "api/forum/getAll" => function() {
        ForumController::getAllForumApi();
    },
    "api/forum/getMyForums" => function() {
        if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) {
            ForumController::getMyForumsApi();
        }
        else {
            ForumController::noAccess();
        }
    },
    "api/users/getUsers" => function() {
        if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) {
            UserController::getUsers();
        }
        else {
            ForumController::noAccess();
        }
    },
    "api/forum/getUserForums" => function() {
        if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) {
            ForumController::getUserForumsApi();
        }
        else {
            ForumController::noAccess();
        }
    },
    "myprofile" => function() {
        if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) {
            ForumController::myprofile();
        }
        else {
            ForumController::noAccess();
        }
    },
    "myprofile/passwordChange" => function() {
        if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) {
            ForumController::passwordUpdate();
        }
        else {
            ForumController::noAccess();
        }
    },
    "forum/addComment" => function() {
        if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) {
            ForumController::addComment();
        }
        else {
            ForumController::noAccess();
        }
    },
    "forum/editComment" => function() {
        if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) {
            ForumController::editComment();
        }
        else {
            ForumController::noAccess();
        }
    },
    "user/updateInfo" => function() {
        if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) {
            ForumController::updateUserInfo();
        }
        else {
            ForumController::noAccess();
        }
    },
    "mymessages" => function() {
        if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) {
            ForumController::myMessages();
        }
        else {
            ForumController::noAccess();
        }
    },
    "messages" => function() {
        if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) {
            MessagesController::getDirectMessages();
        }
        else {
            ForumController::noAccess();
        }
    },
    "messages/sendMessage" => function() {
        if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) {
            MessagesController::sendMessage();
        }
        else {
            ForumController::noAccess();
        }
    },
    "message/delete" => function() {
        if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) {
            MessagesController::deleteMessage();
        }
        else {
            ForumController::noAccess();
        }
    },
    "users/search" => function() {
        if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) {
            UserController::searchUsers();
        }
        else {
            ForumController::noAccess();
        }
    },
    "user" => function() {
        if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) {
            UserController::showUser();
        }
        else {
            ForumController::noAccess();
        }
    },
    "guest" => function() {
        UserController::guest();
    },
    "forum/likeMessage" => function() {
        if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) {
            ForumController::likeMessage();
        }
        else {
            ForumController::noAccess();
        }
    },
    "forum/unlikeMessage" => function() {
        if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) {
            ForumController::unlikeMessage();
        }
        else {
            ForumController::noAccess();
        }
    },
    "" => function () {
        if(isset($_SESSION['user'])) {
            ViewHelper::redirect(BASE_URL . "forum");
        }
        else {
            ViewHelper::redirect(BASE_URL . "login");
        }
    },
];





try {
    if (isset($urls[$path])) {
        $urls[$path]();
    } else {
        ViewHelper::error404();
    }
} catch (Exception $e) {
    echo "An error occurred: <pre>$e</pre>";
    ViewHelper::error404();
} 
