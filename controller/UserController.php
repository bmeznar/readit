<?php

require_once("model/ForumDB.php");
require_once("model/UserDB.php");
require_once("ViewHelper.php");

class UserController {

    public static function getUsers() {
        if (isset($_GET["query"]) && !empty($_GET["query"])) {
            $hits = UserDB::searchUsers($_GET["query"]);
        } else {
            $hits = [];
        }

        header('Content-type: application/json; charset=utf-8');
        echo json_encode($hits);
    }

    public static function searchUsers() {
        ViewHelper::render("view/searchusers.php");
    }

    public static function showUser() {
        if (isset($_GET["id"]) && !empty($_GET["id"])) {
            $data = UserDB::getUser($_GET['id']);
            $forums = ForumDB::searchUsersForums($_GET['id']);
            ViewHelper::render("view/userShow.php", ["data" => $data, "forums" => $forums]);
        } else {
            $hits = [];
        }
    }

    public static function guest() {
        ViewHelper::render("view/forum_list.php", ["forums" => ForumDB::getAllForums()]);
    }

}
