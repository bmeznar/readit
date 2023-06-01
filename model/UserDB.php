<?php

require_once("model/ForumDB.php");

class UserDB {

    public static function searchUsers($query) {
        $db = DBInit::getInstance();

        $statement = $db->prepare(" SELECT * 
                                    FROM users
                                    WHERE username LIKE :query AND id <> :user_id");
        $statement->bindValue(":query", '%' . $query . '%');
        $statement->bindParam(":user_id", $_SESSION['user_id'], PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll();
    }

    public static function getUser($id) {
        $db = DBInit::getInstance();

        $statement = $db->prepare(" SELECT id, username, email, birthday 
                                    FROM users
                                    WHERE id = :id");
        $statement->bindParam(":id", $id, PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetch();
    }

}
