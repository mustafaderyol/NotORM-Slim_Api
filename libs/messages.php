<?php

require_once dirname(__FILE__) . '/../third-party/NotORM.php';
require_once dirname(__FILE__) . '/../configs/db.php';

class uup {

    private $pdo;
    private $db;

    public function __construct() {
    
        $this->pdo = new PDO('mysql:dbname='.DB_NAME.';host='.DB_HOST,DB_USER,DB_PASS);
        $this->db = new NotORM($this->pdo);


    }

    public function getAllMessages() {
        $sql=$this->db->messages();
        $usrs = array();
        foreach ($sql as $data) {
            $usrs[]  = array(
                "id"                    => $data["id"],
                "user_id"               => $data["user_id"],
                "message_parent_id"     => $data["message_parent_id"],
                "message"               => $data["message"],
                "mesage_date"           => $data["mesage_date"],
                "sender_ip"             => $data["sender_ip"],
                "university_id"         => $data["university_id"]
            );
        }
        return $usrs;

    }

    public function getMessageViewWithId($id) {

        $data = $this->db->messages("id = ?",$id)->fetch();
        $usr = array(
                "id"                    => $data["id"],
                "user_id"               => $data["user_id"],
                "message_parent_id"     => $data["message_parent_id"],
                "message"               => $data["message"],
                "mesage_date"           => $data["mesage_date"],
                "sender_ip"             => $data["sender_ip"],
                "university_id"         => $data["university_id"]
        );
        return $usr;
    }

    public function getMaxViewedMessage() {

        $view = $this->db->messages()->max("id");
        $data = $this->db->messages("id = ?",$view)->fetch();
        $usr = array(
                "id"                    => $data["id"],
                "user_id"               => $data["user_id"],
                "message_parent_id"     => $data["message_parent_id"],
                "message"               => $data["message"],
                "mesage_date"           => $data["mesage_date"],
                "sender_ip"             => $data["sender_ip"],
                "university_id"         => $data["university_id"]
        );
        return $usr;

    }


    public function getMessage($id) {

        $sql = $this->db->messages()->where("message_parent_id = ?",$id);
        foreach ($sql as $data) {
            $usrs[]  = array(
                "id"                    => $data["id"],
                "user_id"               => $data["user_id"],
                "message_parent_id"     => $data["message_parent_id"],
                "message"               => $data["message"],
                "mesage_date"           => $data["mesage_date"],
                "sender_ip"             => $data["sender_ip"],
                "university_id"         => $data["university_id"]
        );
        }
        return $usrs;

    }


    public function getMessageViewWithUniversity($id) {

        $sql = $this->db->messages("university_id = ?",$id)->where("message_parent_id = 0");
        foreach ($sql as $data) {
            $usrs[]  = array(
                "id"                    => $data["id"],
                "user_id"               => $data["user_id"],
                "message_parent_id"     => $data["message_parent_id"],
                "message"               => $data["message"],
                "mesage_date"           => $data["mesage_date"],
                "sender_ip"             => $data["sender_ip"],
                "university_id"         => $data["university_id"]
            );
        }
        return $usrs;

    }

    public function deleteUserId($id) {

        if($data = $this->db->messages("id = ?",$id)->delete()) {
            
            $success = array(
                "success"     => "success"
            );
            return $success;
        } else {
            $error = array(
                "error"     => "DELETE_ERROR"
            );
            return $error;
        }

    }

    public function saveContent($content) {

        if($data = $this->db->messages()->insert($content)) {
            $usrs = array(
                "id"                    => $data["id"],
                "user_id"               => $data["user_id"],
                "message_parent_id"     => $data["message_parent_id"],
                "message"               => $data["message"],
                "mesage_date"           => $data["mesage_date"],
                "sender_ip"             => $data["sender_ip"],
                "university_id"         => $data["university_id"]
            );
            return $usrs;
        } else {
            $error = array(
                "error"     => "SAVE_ERROR"
            );
            return $error;
        }

    }


    public function updateContent($content) {

        $data = $this->db->messages('id', $content["id"])->fetch();
        if($data) 
        { 
            $usr = array(
                "message"               => $content["message"]
            );
            if($data->update($usr)) 
            { 
                return $usr;
            } 
            else 
            { 
                $error = array(
                    "error"     => "UPDATE_ERROR"
                );
                return $error; 
            }

        }
    }


    public function errorNotFound() {
        $error = array(
            "error"     => "NOT_FOUND"
        );
        return $error;
    }
}


