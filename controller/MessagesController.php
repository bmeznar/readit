<?php

require_once("model/ForumDB.php");
require_once("model/MessagesDB.php");
require_once("ViewHelper.php");

class MessagesController {

    public static function getDirectMessages() {
        
        if (isset($_GET["id"])) {
            $messages = MessagesDB::getDirectMesssages($_GET["id"]);
            if (sizeof($messages) > 0) {
                ViewHelper::render("view/directMessage.php", ["messages" => $messages, "reciever" => $_GET["id"]]);
            }
            else {
                // echo "Ni sporočil z to osebo";
                $_SESSION['site_message'] = "An error occured. Seems like you don't have any messages with this user.";
                ViewHelper::redirect(BASE_URL . "forum");
            }
        } else {
            $_SESSION['site_message'] = "An error occured when loading conversation. It appears user doesnt exist.";
            // echo "napaka pri nalaganju direktnih sporočil.";
            ViewHelper::redirect(BASE_URL . "forum");
        }
    }

    public static function sendMessage() {
        $validData =    isset($_POST["message"]) && !empty($_POST["message"]) && 
                        isset($_POST["reciever_id"]) && !empty($_POST["reciever_id"]);

        if ($validData) {
            MessagesDB::sendMessage($_POST["message"], $_POST["reciever_id"]);
            ViewHelper::redirect(BASE_URL . "messages?id=" . $_POST["reciever_id"]);
        } else {
            $_SESSION['site_message'] = "Could not send a message, because there seems to be missing some required data. Please make sure you have filled out all input fields.";
            ViewHelper::redirect(BASE_URL . "forum");
        }
    }

    public static function deleteMessage() {
        $validData =    isset($_POST["message_id"]) && !empty($_POST["message_id"]) &&
                        isset($_POST['forum_id']) && !empty($_POST["forum_id"]);

        if ($validData) {
            MessagesDB::deleteMessage($_POST["message_id"]);
            ViewHelper::redirect(BASE_URL . "forum?id=" . $_POST["forum_id"]);
        } else {
            $_SESSION['site_message'] = "There was an error deleting a message. Please try again later.";
            ViewHelper::redirect(BASE_URL . "forum");
        }
    }

}
