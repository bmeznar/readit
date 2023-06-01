<?php

require_once("model/ForumDB.php");

class MessagesDB {

    public static function getDirectMesssages($user_id) {
        $db = DBInit::getInstance();

        $statement = $db->prepare(" SELECT DISTINCT dm.*, u1.id, u1.username
                                    FROM direct_messages dm INNER JOIN users u1 ON dm.sender_id = u1.id INNER JOIN users u2 ON dm.receiver_id = u2.id
                                    WHERE (dm.sender_id = :sender_id AND dm.receiver_id = :receiver_id) OR
                                    (dm.sender_id = :receiver_id AND dm.receiver_id = :sender_id)
                                    ORDER BY dm.date ASC;");
        $statement->bindParam(":sender_id", $_SESSION['user_id'], PDO::PARAM_INT);
        $statement->bindParam(":receiver_id", $user_id, PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll();
    }

    public static function sendMessage($message, $reciever_id) {
        $db = DBInit::getInstance();

        $current_date = date('y-m-d G:i:s');

        $statement = $db->prepare("INSERT INTO direct_messages (message, sender_id, receiver_id, date)
            VALUES (:message, :sender_id, :reciever_id, :date)");
        $statement->bindParam(":message", $message, PDO::PARAM_STR);
        $statement->bindParam(":sender_id", $_SESSION['user_id'], PDO::PARAM_INT);
        $statement->bindParam(":reciever_id", $reciever_id, PDO::PARAM_INT);
        $statement->bindParam(":date", $current_date, PDO::PARAM_STR);
        $statement->execute();
    }

    public static function deleteMessage($message_id) {
        $db = DBInit::getInstance();

        $statement = $db->prepare(" DELETE FROM forum_message
                                    WHERE id = :id;");
        $statement->bindParam(":id", $message_id, PDO::PARAM_INT);
        $statement->execute();
    }

}
