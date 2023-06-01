<?php

require_once "DBInit.php";

class ForumDB {

    public static function login($user, $pass) {
        $db = DBInit::getInstance();

        $statement = $db->prepare("SELECT * FROM users WHERE username = :user");
        $statement->bindParam(":user", $user, PDO::PARAM_STR);
        $statement->execute();

        $result = $statement->fetchAll();
        if(!empty($result)) {
            return $result;
        }
        else {
            return null;
        }
    }

    public static function registerUser($user, $pass, $email, $birth) {
        $db = DBInit::getInstance();

        $statement = $db->prepare("INSERT INTO users (username, password, email, birthday)
            VALUES (:username, :password, :email, :birthday)");
        $statement->bindParam(":username", $user, PDO::PARAM_STR);
        $statement->bindParam(":password", password_hash($pass, PASSWORD_DEFAULT), PDO::PARAM_STR);
        $statement->bindParam(":email", $email, PDO::PARAM_STR);
        $statement->bindParam(":birthday", $birth, PDO::PARAM_STR);
        $statement->execute();
    }

    public static function checkUsername($user) {
        $db = DBInit::getInstance();

        $statement = $db->prepare("SELECT * FROM users WHERE username = :user");
        $statement->bindParam(":user", $user, PDO::PARAM_STR);
        $statement->execute();

        $result = $statement->fetchAll();
        if(!empty($result)) {
            return $result;
        }
        else {
            return null;
        }
    }

    public static function checkEmail($email) {
        $db = DBInit::getInstance();

        $statement = $db->prepare("SELECT * FROM users WHERE email = :email");
        $statement->bindParam(":email", $email, PDO::PARAM_STR);
        $statement->execute();

        $result = $statement->fetchAll();
        if(!empty($result)) {
            return $result;
        }
        else {
            return null;
        }
    }

    public static function getAllForums() {
        $db = DBInit::getInstance();

        $statement = $db->prepare(" SELECT f.*, COUNT(fm.id) 
                                    FROM forums f INNER JOIN forum_message fm on fm.forum_id=f.id 
                                    GROUP BY f.id
                                    ORDER BY date_created DESC");
        $statement->execute();

        return $statement->fetchAll();
    }

    public static function get($id) {
        $db = DBInit::getInstance();

        $statement = $db->prepare("SELECT * FROM forums WHERE id = :id");
        $statement->bindParam(":id", $id, PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll();
    }

    public static function getComments($id) {
        $db = DBInit::getInstance();

        $statement = $db->prepare(" SELECT fm.*, u.username, COUNT(uv.upvote) AS likes
                                    FROM forum_message as fm INNER JOIN users as u ON fm.user_id=u.id LEFT JOIN upvote uv ON uv.forum_message_id = fm.id
                                    WHERE forum_id = :id 
                                    GROUP BY fm.id
                                    ORDER BY date ASC;");
        $statement->bindParam(":id", $id, PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll();
    }

    public static function createNewForum($title, $message) {
        $current_date = date('y-m-d G:i:s');

        $db = DBInit::getInstance();
        $statement = $db->prepare(" INSERT INTO forums (title, user_id, date_created)
                                    VALUES (:title, :user_id, :date)");
        $statement->bindParam(":title", $title, PDO::PARAM_STR);
        $statement->bindParam(":user_id", $_SESSION['user_id'], PDO::PARAM_INT);
        $statement->bindParam(":date", $current_date, PDO::PARAM_STR);
        $statement->execute();

        $db = DBInit::getInstance();
        $statement = $db->prepare("SELECT id FROM forums WHERE title = :title AND date_created = :date_created");
        $statement->bindParam(":title", $title, PDO::PARAM_STR);
        $statement->bindParam(":date_created", $current_date, PDO::PARAM_STR);
        $statement->execute();
        $result = $statement->fetchAll();

        $db = DBInit::getInstance();
        $statement = $db->prepare(" INSERT INTO forum_message (user_id, message, date, edited_date, forum_id)
                                    VALUES (:user_id, :message, :date, :edited_date, :forum_id)");
        $statement->bindParam(":user_id", $_SESSION['user_id'], PDO::PARAM_INT);
        $statement->bindParam(":message", $message, PDO::PARAM_STR);
        $statement->bindParam(":date", $current_date, PDO::PARAM_STR);
        $statement->bindParam(":edited_date", $current_date, PDO::PARAM_STR);
        $statement->bindParam(":forum_id", $result[0]['id'], PDO::PARAM_INT);
        $statement->execute();
    }

    public static function getAllApiForums() {
        $db = DBInit::getInstance();

        $statement = $db->prepare(" SELECT * 
                                    FROM forums");
        $statement->execute();

        return $statement->fetchAll();
    }

    public static function searchForums($query) {
        $db = DBInit::getInstance();

        /*$statement = $db->prepare(" SELECT * 
                                    FROM forums
                                    WHERE title LIKE :query");*/
        $statement = $db->prepare(" SELECT f.*, COUNT(fm.id) as comment_count 
                                    FROM forums f INNER JOIN forum_message fm on fm.forum_id=f.id 
                                    WHERE f.title LIKE :query
                                    GROUP BY f.id");                            
        $statement->bindValue(":query", '%' . $query . '%');
        $statement->execute();

        return $statement->fetchAll();
    }

    public static function searchUsersForums($user_id) {
        $db = DBInit::getInstance();

        $statement = $db->prepare(" SELECT f.*, COUNT(fm.id) as comment_count 
                                    FROM forums f INNER JOIN forum_message fm on fm.forum_id=f.id
                                    WHERE f.user_id LIKE :user_id
                                    GROUP BY f.id");
        $statement->bindValue(":user_id", '%' . $user_id . '%');
        $statement->execute();

        return $statement->fetchAll();
    }

    public static function updatePassword($new_pass) {
        $db = DBInit::getInstance();

        $statement = $db->prepare(" UPDATE users
                                    SET password = :pass
                                    WHERE id = :user_id");
        $statement->bindParam(":pass", password_hash($new_pass, PASSWORD_DEFAULT), PDO::PARAM_STR);
        $statement->bindParam(":user_id", $_SESSION['user_id'], PDO::PARAM_INT);
        $statement->execute();
    }

    public static function createNewComment($message, $forum_id) {
        $current_date = date('y-m-d G:i:s');

        $db = DBInit::getInstance();

        $statement = $db->prepare("INSERT INTO forum_message (user_id, message, date, edited_date, forum_id)
            VALUES (:user_id, :message, :date, :date_edited, :forum_id)");
        $statement->bindParam(":user_id", $_SESSION['user_id'], PDO::PARAM_INT);
        $statement->bindParam(":message", $message, PDO::PARAM_STR);
        $statement->bindParam(":date", $current_date, PDO::PARAM_STR);
        $statement->bindParam(":date_edited", $current_date, PDO::PARAM_STR);
        $statement->bindParam(":forum_id", $forum_id, PDO::PARAM_INT);
        $statement->execute();
    }

    public static function  editComment($message, $comment_id) {
        $db = DBInit::getInstance();

        $current_date = date('y-m-d h:i:s');

        $statement = $db->prepare(" UPDATE forum_message
                                    SET message = :message, edited_date =  :current_date 
                                    WHERE id = :comment_id");
        $statement->bindParam(":message", $message, PDO::PARAM_STR);
        $statement->bindParam(":current_date", $current_date, PDO::PARAM_STR);
        $statement->bindParam(":comment_id", $comment_id, PDO::PARAM_INT);
        $statement->execute();
    }

    public static function editUser($username, $email, $birthday) {
        $db = DBInit::getInstance();

        $statement = $db->prepare(" UPDATE users
                                    SET username = :username, email = :email, birthday = :birthday 
                                    WHERE id = :user_id");
        $statement->bindParam(":username", $username, PDO::PARAM_STR);
        $statement->bindParam(":email", $email, PDO::PARAM_STR);
        $statement->bindParam(":birthday", $birthday, PDO::PARAM_STR);
        $statement->bindParam(":user_id", $_SESSION['user_id'], PDO::PARAM_INT);
        $statement->execute();

        $_SESSION['user'] = $username;
        $_SESSION['email'] = $email;
        $_SESSION['birthday'] = $birthday;
    }

    public static function myDMs() {
        $db = DBInit::getInstance();

        // $statement = $db->prepare(" SELECT DISTINCT u.id, u.username, dm.message
        //                             FROM direct_messages dm INNER JOIN users u ON (dm.sender_id = u.id OR dm.receiver_id = u.id)
        //                             WHERE u.id != :user_id
        //                             GROUP BY u.id;");
        $statement = $db->prepare(" SELECT DISTINCT u.id, u.username
                                    FROM direct_messages dm INNER JOIN users u ON (dm.sender_id = u.id OR dm.receiver_id = u.id)
                                    WHERE u.id != :user_id AND (dm.sender_id = :user_id OR dm.receiver_id = :user_id);");
        $statement->bindParam(":user_id", $_SESSION['user_id'], PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll();
    }

    public static function messageLikes($fm_id) {
        $db = DBInit::getInstance();

        $statement = $db->prepare("SELECT
                                    (SELECT COUNT(*) as likes
                                    FROM upvote
                                    WHERE forum_message_id = :fm_id AND upvote = true) - 
                                    (SELECT COUNT(*) as likes
                                    FROM upvote
                                    WHERE forum_message_id = :fm_id AND upvote = true);");
        $statement->bindParam(":fm_id", $fm_id, PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll();
    }

    public static function likeMessage($message_id) {
        $db = DBInit::getInstance();

        $statement = $db->prepare(" INSERT INTO upvote (upvote, forum_message_id, user_id)
                                    VALUES (1, :message_id, :user_id)");
        $statement->bindParam(":message_id", $message_id, PDO::PARAM_INT);
        $statement->bindParam(":user_id", $_SESSION['user_id'], PDO::PARAM_INT);
        $statement->execute();
    }

    public static function unlikeMessage($message_id) {
        $db = DBInit::getInstance();

        $statement = $db->prepare(" DELETE FROM upvote
                                    WHERE forum_message_id = :message_id;");
        $statement->bindParam(":message_id", $message_id, PDO::PARAM_INT);
        $statement->execute();
    }

    public static function getAllUserLikes($f_id) {
        $db = DBInit::getInstance();

        $statement = $db->prepare(" SELECT u.forum_message_id
                                    FROM upvote u INNER JOIN forum_message fm ON u.forum_message_id = fm.id INNER JOIN forums f ON f.id = fm.forum_id
                                    WHERE f.id = :f_id AND u.user_id = :user_id");
        $statement->bindParam(":f_id", $f_id, PDO::PARAM_INT);
        $statement->bindParam(":user_id", $_SESSION['user_id'], PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll();
    }

}
